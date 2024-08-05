@extends('padrao')
@section('content')

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Cadastrar Turma</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('turnos.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Turno</label>
                            <input class="form-control" type="text" name="name" id="">
                        </div>

                        <div class="form-group mt-2">
                            <button class="btn btn-success">Cadastrar</button>
                        </div>
                    </form>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Turnos</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                    Cadastrar
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Turno</th>

                        <th>Ações</th>

                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turnos as $turno)

                        <tr>
                            <td>{{$turno->name}}</td>

                            <td>
                                <a href="{{route('turnos.show',$turno)}}" class="btn btn-default">Horários</a></td>
                        </tr>

                    @empty
                    @endforelse
                    <!-- Assuming 6 periods from 7:00 to 12:00 -->

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
