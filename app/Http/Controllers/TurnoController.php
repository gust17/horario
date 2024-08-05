<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::all();

        return view('turnos.index', compact('turnos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        // Crie a nova turma usando os dados validados
        Turno::create($validatedData);

        // Redirecione ou retorne uma resposta
        return redirect()->route('turnos.index')->with('success', 'Turno cadastrado com sucesso!');

    }

    public function show(Turno $turno)
    {
        $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];
        //dd($turno);
        $timeSlots = Horario::whereIn('day_of_week', $daysOfWeek)->where('turno_id', $turno->id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        //dd($timeSlots);

        $earliestTime = $timeSlots->flatten()->min('start_time');
        $latestTime = $timeSlots->flatten()->max('end_time');

        //dd($earliestTime,$latestTime);


        return view('turnos.show', compact('turno', 'daysOfWeek', 'timeSlots','earliestTime', 'latestTime'));
    }

    public function horario(Request $request, Turno $turno)
    {
        //dd($request->all());
        $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];

        // dd($daysOfWeek);


        foreach ($request->horarios as $horario){
            //dd($horario);
            foreach ($daysOfWeek as $day) {


                $grava = [
                    'turno_id' => $turno->id,
                    'day_of_week' => $day,
                    'start_time' => $horario['start_time'],
                    'end_time' => $horario['end_time'],
                ];

                //dd($grava);
                \App\Models\Horario::create($grava);
            }
        }


      return redirect()->back();
    }


}
