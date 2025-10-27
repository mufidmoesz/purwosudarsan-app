<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Spouse;


class PersonController extends Controller
{
    //
    public function index()
    {
        $people = Person::all();
        return view('person.index', compact('people'));
    }

    public function show($id)
    {
        $person = Person::findOrFail($id);
        return view('person.show', compact('person'));
    }

    public function create()
    {
        return view('person.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mother_id' => 'nullable|exists:people,id',
            'father_id' => 'nullable|exists:people,id',
            'gender' => 'required|string|in:male,female',
            'photo_url' => 'nullable|url',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        Person::create($validated);

        return redirect()->route('person.index');
    }

    public function edit($id)
    {
        $person = Person::findOrFail($id);
        return view('person.edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mother_id' => 'nullable|exists:people,id',
            'father_id' => 'nullable|exists:people,id',
            'gender' => 'required|string|in:male,female',
            'photo_url' => 'nullable|url',
            'birth_date' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $person->update($validated);

        return redirect()->route('person.show', $person);
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect()->route('person.index');
    }

    public function addSpouse(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $validated = $request->validate([
            'spouse_id' => 'required|exists:people,id|different:'.$id,
        ]);

        // Avoid duplicate entries
        if (!$person->spouses()->where('spouse_id', $validated['spouse_id'])->exists()) {
            $person->spouses()->attach($validated['spouse_id']);
        }

        return redirect()->route('person.show', $person);
    }

    public function removeSpouse($id, $spouseId)
    {
        $person = Person::findOrFail($id);
        $person->spouses()->detach($spouseId);

        return redirect()->route('person.show', $person);
    }
}
