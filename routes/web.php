<?php

use App\Http\Controllers\TurnoController;
use App\Models\Horario;
use App\Models\Professor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('datas', function () {

    $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];

    // Obter todos os horários
    $timeSlots = Horario::whereIn('day_of_week', $daysOfWeek)
        ->orderBy('start_time')
        ->get()
        ->groupBy('day_of_week');

    // Obter todas as turmas com os relacionamentos
    //$schoolClasses = SchoolClass::with(['timeSlot', 'user'])->get();
    $professors = Professor::all();
    return view('teste', compact('daysOfWeek', 'timeSlots','professors'));

});

Route::resource('turmas', \App\Http\Controllers\TurmaController::class);
Route::post('turmas/horario/{turma}',[\App\Http\Controllers\TurmaController::class, 'horario'])->name('turmas.horario');


Route::resource('turnos',TurnoController::class);
///Route::resource('turnos');



Route::get('/teste', function () {


    $materia = \App\Models\Materia::create(['name'=>'Matematica']);


    $professor = Professor::create(['name'=>'Luiz','materia_id'=>$materia->id]);


//    $horarios = Horario::all();
//
//    dd($horarios);
//    $daysOfWeek = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];
//    $startTime = \Carbon\Carbon::createFromTimeString('07:00:00');
//    //dd($daysOfWeek);
//    $shift = \App\Models\Turno::create(['name' => 'Manhã']);
//
//
//    foreach ($daysOfWeek as $day) {
//        for ($i = 0; $i < 6; $i++) {
//            $endTime = (clone $startTime)->addHour();
//            \App\Models\Horario::create([
//                'turno_id' => $shift->id,
//                'day_of_week' => $day,
//                'start_time' => $startTime->format('H:i:s'),
//                'end_time' => $endTime->format('H:i:s'),
//            ]);
//            $startTime->addHour();
//        }
//        $startTime = \Carbon\Carbon::createFromTimeString('07:00:00'); // Reset start time for next day
//    }
});

Route::post('gerar_horario',function (\Illuminate\Http\Request $request){
    //dd($request->all());


    $professor['id'] =1;

    foreach ($request['disponibilidade'] as $key => $value) {

        $grava = [


            'professor_id'=>$professor['id'],
            'horario_id'=>$key,
            'disponivel'=>$value,
        ];

        ///dd($grava);
       \App\Models\Disponibilidade::create($grava);
    };
});
