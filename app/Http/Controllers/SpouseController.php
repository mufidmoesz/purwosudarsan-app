<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Spouse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SpouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spousePairs = $this->uniquePairs(
            Spouse::with(['person:id,name', 'partner:id,name'])->get()
        );

        return view('admin.spouse.index', ['spouses' => $spousePairs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $people = Person::orderBy('name')->get();

        return view('admin.spouse.create', compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        [$personId, $spouseId] = $this->validatedPair($request);

        if ($this->pairExists($personId, $spouseId)) {
            return back()
                ->withErrors(['person_id' => 'This spouse relationship already exists.'])
                ->withInput();
        }

        Spouse::create([
            'person_id' => $personId,
            'spouse_id' => $spouseId,
        ]);

        // Clean up legacy reversed entries if they exist.
        Spouse::where('person_id', $spouseId)
            ->where('spouse_id', $personId)
            ->delete();

        return redirect()
            ->route('admin.spouses.index')
            ->with('status', 'Spouse relationship added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spouse $spouse)
    {
        $people = Person::orderBy('name')->get();

        return view('admin.spouse.edit', [
            'spouse' => $spouse,
            'people' => $people,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spouse $spouse)
    {
        [$personId, $spouseId] = $this->validatedPair($request);

        $duplicate = Spouse::where(function ($query) use ($personId, $spouseId) {
            $query->where(function ($q) use ($personId, $spouseId) {
                $q->where('person_id', $personId)
                    ->where('spouse_id', $spouseId);
            })->orWhere(function ($q) use ($personId, $spouseId) {
                $q->where('person_id', $spouseId)
                    ->where('spouse_id', $personId);
            });
        })
            ->where('id', '!=', $spouse->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['person_id' => 'This spouse relationship already exists.'])
                ->withInput();
        }

        $spouse->update([
            'person_id' => $personId,
            'spouse_id' => $spouseId,
        ]);

        // Clean up any legacy duplicate row that may exist with reversed order.
        Spouse::where('person_id', $spouseId)
            ->where('spouse_id', $personId)
            ->where('id', '!=', $spouse->id)
            ->delete();

        return redirect()
            ->route('admin.spouses.index')
            ->with('status', 'Spouse relationship updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spouse $spouse)
    {
        $reverse = Spouse::where('person_id', $spouse->spouse_id)
            ->where('spouse_id', $spouse->person_id)
            ->first();

        if ($reverse) {
            $reverse->delete();
        }

        $spouse->delete();

        return redirect()
            ->route('admin.spouses.index')
            ->with('status', 'Spouse relationship removed successfully.');
    }

    /**
     * Normalize and validate spouse pair input.
     */
    private function validatedPair(Request $request): array
    {
        $validated = $request->validate([
            'person_id' => ['required', 'exists:people,id', 'different:spouse_id'],
            'spouse_id' => ['required', 'exists:people,id'],
        ]);

        $ids = [$validated['person_id'], $validated['spouse_id']];
        sort($ids);

        return $ids;
    }

    /**
     * Ensure we do not persist duplicate pairs.
     */
    private function pairExists(int $personId, int $spouseId): bool
    {
        return Spouse::where(function ($query) use ($personId, $spouseId) {
            $query->where(function ($q) use ($personId, $spouseId) {
                $q->where('person_id', $personId)
                    ->where('spouse_id', $spouseId);
            })->orWhere(function ($q) use ($personId, $spouseId) {
                $q->where('person_id', $spouseId)
                    ->where('spouse_id', $personId);
            });
        })->exists();
    }

    /**
     * Deduplicate pairs for index display.
     */
    private function uniquePairs(Collection $pairs): Collection
    {
        return $pairs
            ->filter(fn ($pair) => $pair->person && $pair->partner)
            ->unique(function ($pair) {
                return collect([$pair->person_id, $pair->spouse_id])
                    ->sort()
                    ->join('-');
            })
            ->sortBy(function ($pair) {
                return $pair->person->name . ' ' . $pair->partner->name;
            })
            ->values();
    }
}
