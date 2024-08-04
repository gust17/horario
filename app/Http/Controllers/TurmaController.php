<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Professor;
use App\Models\Turma;
use App\Models\Turno;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        $turmas = Turma::all();
        $turnos = Turno::all();

        return view('turmas.index', compact('turmas', 'turnos'));
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'turno_id' => 'required|integer',
            'serie' => 'required|string|max:255',
        ]);

        // Crie a nova turma usando os dados validados
        Turma::create($validatedData);

        // Redirecione ou retorne uma resposta
        return redirect()->route('turmas.index')->with('success', 'Turma cadastrada com sucesso!');

    }


    public function show(Turma $turma)
    {
        $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];

        // Obter todos os horários
        $timeSlots = Horario::whereIn('day_of_week', $daysOfWeek)->where('turno_id', $turma->turno_id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $professors = Professor::all();
        return view('turmas.horario', compact('daysOfWeek', 'timeSlots', 'professors', 'turma'));
    }

    public function horario(Request $request, Turma $turma)
    {


        $filteredHorarios = array_filter($request->horarios, function ($value) {
            return !is_null($value);
        });


        foreach ($filteredHorarios as $key => $value) {
            $turma->horarios()->attach($key, ['professor_id' => $value]);

        };


        return redirect()->back();
    }


}
