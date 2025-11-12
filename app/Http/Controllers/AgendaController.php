<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('date')->orderBy('time')->paginate(10);

        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        Agenda::create($validated);

        return redirect()
            ->route('admin.agendas.index')
            ->with('status', 'Agenda created successfully.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $this->validatedData($request);

        $agenda->update($validated);

        return redirect()
            ->route('admin.agendas.index')
            ->with('status', 'Agenda updated successfully.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()
            ->route('admin.agendas.index')
            ->with('status', 'Agenda deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }
}

