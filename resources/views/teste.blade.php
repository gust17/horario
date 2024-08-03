<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Class Schedule</h1>
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
                                        <option value="SIM">SIM</option>
                                        <option value="Nao">NAO</option>
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
</body>
</html>