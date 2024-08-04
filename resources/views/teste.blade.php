@extends('padrao')
@section('content')
<div class="container mt-5">
    <h1>HORARIO DA TURMA X</h1>

    <div class="card">
        <div class="card-body">
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
                @for($i = 7; $i <= 12; $i++) <!-- Assuming 6 periods from 7:00 to 12:00 -->
                <tr>
                    <td>{{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i + 1) }}</td>
                    @foreach($daysOfWeek as $day)
                        <td>
                            @if(isset($timeSlots[$day]))
                                @foreach($timeSlots[$day] as $timeSlot)
                                    @if($timeSlot->start_time == sprintf('%02d:00:00', $i))

                                        <select name="professor_{{ $day }}_{{ $i }}" id="professor_{{ $day }}_{{ $i }}">
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
                                                    <option value="{{$professor->id}}">{{$professor->name}}</option>
                                                @endif
                                            @empty
                                                <option value="">Nenhum professor disponível</option>
                                            @endforelse
                                        </select>
                                        {{--                                @foreach($schoolClasses as $class)--}}
                                        {{--                                    @if($class->time_slot_id == $timeSlot->id)--}}
                                        {{--                                        {{ $class->subject }} ({{ $class->user->name }})--}}
                                        {{--                                    @endif--}}
                                        {{--                                @endforeach--}}
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endfor
                </tbody>
            </table>
            <button>Salvar</button>
        </div>
    </div>

</div>


<div class="container mt-5">
    <h1>PROFESSOR MONTE O SEU HORARIO</h1>


    <form action="{{url('gerar_horario')}}" method="post">
        @csrf

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
            @for($i = 7; $i <= 12; $i++) <!-- Assuming 6 periods from 7:00 to 12:00 -->
            <tr>
                <td>{{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i + 1) }}</td>
                @foreach($daysOfWeek as $day)
                    <td>

                        @if(isset($timeSlots[$day]))
                            @foreach($timeSlots[$day] as $timeSlot)

                                @if($timeSlot->start_time == sprintf('%02d:00:00', $i))
                                    <select name="disponibilidade[{{$timeSlot->id}}]" id="">
                                        <option value="1">SIM</option>
                                        <option value="0">NAO</option>
                                    </select>
                                    {{--                                @foreach($schoolClasses as $class)--}}
                                    {{--                                    @if($class->time_slot_id == $timeSlot->id)--}}
                                    {{--                                        {{ $class->subject }} ({{ $class->user->name }})--}}
                                    {{--                                    @endif--}}
                                    {{--                                @endforeach--}}
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


@endsection
