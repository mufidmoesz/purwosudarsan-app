<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Carbon\Carbon;

class PublicAgendaController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $agendas = Agenda::whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(9);

        return view('agendas.index', compact('agendas'));
    }
}

