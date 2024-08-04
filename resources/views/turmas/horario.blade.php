@extends('padrao')
@section('content')
    <div class="container mt-5">
        <h1>HORARIO DA TURMA {{$turma->name}} {{$turma->serie}}</h1>

        <div class="card">
            <div class="card-body">

                <form action="{{route('turmas.horario',$turma)}}" method="post">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Time</th>
                            @foreach($daysOfWeek as $day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 7; $i <= 12; $i++)
                            <!-- Assuming 6 periods from 7:00 to 12:00 -->
                            <tr>
                                <td>{{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i + 1) }}</td>
                                @foreach($daysOfWeek as $day)
                                    <td>
                                        @if(isset($timeSlots[$day]))
                                            @foreach($timeSlots[$day] as $timeSlot)
                                                @if($timeSlot->start_time == sprintf('%02d:00:00', $i))
                                                    @csrf

                                                    @php
                                                        $assignedProfessor = null;
                                                        // Verifica se o horário está associado a um professor para a turma
                                                        foreach($turma->horarios as $horario) {
                                                            if($horario->id == $timeSlot->id) {
                                                                $assignedProfessor = $horario->pivot->professor_id;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @if($assignedProfessor)
                                                        @php
                                                            // Obtém o professor associado ao horário
                                                            $professor = $professors->find($assignedProfessor);
                                                        @endphp
                                                        @if($professor)
                                                            {{ $professor->name }} -- {{ $professor->materia->name }}
                                                        @else
                                                            Nenhum professor encontrado
                                                        @endif
                                                    @else
                                                        <select name="horarios[{{ $timeSlot->id }}]" id="professor_{{ $day }}_{{ $i }}">
                                                            <option value="">Selecione um Professor</option>
                                                            @forelse($professors as $professor)
                                                                @php
                                                                    $isAvailable = false;
                                                                    foreach($professor->disponibilidades as $disponibilidade) {
                                                                        if ($disponibilidade->horario_id == $timeSlot->id &&
                                                                            $disponibilidade->disponivel == 1 &&
                                                                            $disponibilidade->ocupado == 0) {
                                                                            $isAvailable = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @if($isAvailable)
                                                                    <option value="{{ $professor->id }}">{{ $professor->name }} {{ $professor->materia->name }}</option>
                                                                @endif
                                                            @empty
                                                                <option value="">Nenhum professor disponível</option>
                                                            @endforelse
                                                        </select>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif

                                    </td>
                                @endforeach
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    <button class="btn btn-success w-100">Salvar</button>

                </form>
            </div>
        </div>

    </div>


    <div class="container mt-5">
        <h1>Horario Montado</h1>


{{--       // @dd($turma->horarios[0]->professors)--}}


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Time</th>
                @foreach($daysOfWeek as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @for($i = 7; $i <= 12; $i++)
                <!-- Assuming 6 periods from 7:00 to 12:00 -->
                <tr>
                    <td>{{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i + 1) }}</td>
                    @foreach($daysOfWeek as $day)
                        <td>

                            @if(isset($timeSlots[$day]))
                                @foreach($timeSlots[$day] as $timeSlot)

                                    @if($timeSlot->start_time == sprintf('%02d:00:00', $i))


{{--                                        {{$timeSlot->id}}--}}
                                    @forelse($turma->horarios as $horario)


                                        @if($horario->id  == $timeSlot->id)

                                                {{$horario->pivot->professor}}
                                            @if($horario->professors->where('id',$horario->pivot->professor_id))
                                                {{$horario->professors->where('id',$horario->pivot->professor_id)[0]->name}} --  {{$horario->professors->where('id',$horario->pivot->professor_id)[0]->materia->name}}


                                            @endif
                                        @endif


                                        @empty
                                    @endforelse

{{--                                        {{$turma->horarios}}--}}
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
            </tbody>
        </table>


    </div>

@endsection
