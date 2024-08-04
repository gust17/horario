@extends('padrao')


@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal -->
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
                    <form action="{{route('turmas.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Turma</label>
                            <input class="form-control" type="text" name="name" id="">
                        </div>
                        <div class="form-group mt-1">
                            <label for="">Turno</label>
                            <select class="form-control" name="turno_id" id="">
                                <option value=""></option>
                                @forelse($turnos as $turno)
                                    <option value="{{$turno->id}}">{{$turno->name}}</option>
                                @empty
                                    <option value="">Sem Turnos</option>
                                @endforelse
                            </select>

                        </div>
                        <div class="form-group mt-1">
                            <label for="">Serie/Ano</label>
                            <input class="form-control" type="text" name="serie" id="">
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
    <!-- FIM -Modal -->

    <div class="container mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Turmas Cadastradas</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Cadastrar</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Turma</th>
                        <th>Serie</th>
                        <th>Turno</th>
                        <th>Ações</th>

                    </tr>
                    </thead>
                    <tbody>

                    @forelse($turmas as $turma)

                        <tr>
                            <td>{{$turma->name}}</td>
                            <td>{{$turma->serie}}</td>
                            <td>{{$turma->turno->name}}</td>
                            <td>
                                <a href="{{route('turmas.show',$turma)}}" class="btn btn-default">Horários</a></td>
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
