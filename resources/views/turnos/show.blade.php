@extends('padrao')
@section('content')

    <div class="container mt-5">
        <h1>HORARIO DA TURMA X</h1>

        <table class="table table-bordered">
            <thead>
            <tr>
                @foreach($daysOfWeek as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @php
                // Encontrar a quantidade máxima de horários por dia para criar as linhas da tabela
                $maxHorarios = $timeSlots->map->count()->max();
            @endphp
            @for($i = 0; $i < $maxHorarios; $i++)
                <tr>
                    @foreach($daysOfWeek as $day)
                        <td>
                            @if(isset($timeSlots[$day][$i]))
                                @php
                                    $horario = $timeSlots[$day][$i];
                                @endphp
                                {{ $horario->start_time }} - {{ $horario->end_time }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
            </tbody>
        </table>



    </div>
    <div class="container mt-4">
        <h1>Cadastrar Horários</h1>
        <form id="horarioForm" method="POST" action="{{route('turnos.horario',$turno)}}">
            @csrf
            <div id="horarioFields">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="start_time_0" class="form-label">Início</label>
                        <input type="time" class="form-control" id="start_time_0" name="horarios[0][start_time]"
                               required>
                    </div>
                    <div class="col-md-5">
                        <label for="end_time_0" class="form-label">Fim</label>
                        <input type="time" class="form-control" id="end_time_0" name="horarios[0][end_time]" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-success" id="addHorarioBtn">Adicionar</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Horários</button>
        </form>
    </div>

    <script>
        let horarioIndex = 1;

        $(document).ready(function () {
            $('#addHorarioBtn').click(function () {
                addHorarioFields();
            });
        });

        function addHorarioFields() {
            const horarioFields = `
            <div class="row mb-3">
                <div class="col-md-5">
                    <label for="start_time_${horarioIndex}" class="form-label">Início</label>
                    <input type="time" class="form-control" id="start_time_${horarioIndex}" name="horarios[${horarioIndex}][start_time]" required>
                </div>
                <div class="col-md-5">
                    <label for="end_time_${horarioIndex}" class="form-label">Fim</label>
                    <input type="time" class="form-control" id="end_time_${horarioIndex}" name="horarios[${horarioIndex}][end_time]" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeHorarioBtn">Remover</button>
                </div>
            </div>
        `;

            $('#horarioFields').append(horarioFields);
            horarioIndex++;
        }

        // Remove a set of horario fields
        $(document).on('click', '.removeHorarioBtn', function () {
            $(this).closest('.row').remove();
        });
    </script>

@endsection
