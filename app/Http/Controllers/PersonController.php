<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = Person::with(['mother:id,name', 'father:id,name'])
            ->withCount('spouses')
            ->orderBy('id')
            ->paginate(12);

        return view('admin.people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $people = Person::orderBy('name')->get();

        return view('admin.people.create', compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $photoPath = $this->storePhoto($request);

        if ($photoPath) {
            $validated['photo_url'] = $photoPath;
        }

        Person::create($validated);

        return redirect()
            ->route('admin.people.index')
            ->with('status', 'Person added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        $people = Person::where('id', '!=', $person->id)
            ->orderBy('name')
            ->get();

        return view('admin.people.edit', compact('person', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $validated = $this->validateData($request, $person->id);

        if ($photoPath = $this->storePhoto($request)) {
            if ($person->photo_url && !filter_var($person->photo_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($person->photo_url);
            }
            $validated['photo_url'] = $photoPath;
        }

        $person->update($validated);

        return redirect()
            ->route('admin.people.index')
            ->with('status', 'Person updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        if ($person->photo_url && !filter_var($person->photo_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($person->photo_url);
        }

        $person->delete();

        return redirect()
            ->route('admin.people.index')
            ->with('status', 'Person removed successfully.');
    }

    /**
     * Validate request data for person CRUD.
     */
    private function validateData(Request $request, ?int $personId = null): array
    {
        $motherRules = ['nullable', 'exists:people,id', 'different:father_id'];
        $fatherRules = ['nullable', 'exists:people,id', 'different:mother_id'];

        if ($personId) {
            $motherRules[] = Rule::notIn([$personId]);
            $fatherRules[] = Rule::notIn([$personId]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'birth_date' => ['nullable', 'date'],
            'death_date' => ['nullable', 'date', 'after_or_equal:birth_date'],
            'mother_id' => $motherRules,
            'father_id' => $fatherRules,
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);
        unset($validated['photo']);

        return $validated;
    }

    /**
     * Persist uploaded photo if present.
     */
    private function storePhoto(Request $request): ?string
    {
        if (!$request->hasFile('photo')) {
            return null;
        }

        $file = $request->file('photo');

        if (!$file->isValid()) {
            return null;
        }

        return $file->store('people/photos', 'public');
    }
}
