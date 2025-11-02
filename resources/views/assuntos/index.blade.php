@extends('layouts.app')

@section('title', 'Assuntos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Assuntos</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Assuntos</h3>
            <div class="card-tools">
                <a href="{{ route('assuntos.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Novo Assunto
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th class="col-sm-1">Código</th>
                        <th class="col-sm-5">Descrição</th>
                        <th class="col-sm-2">Total de Livros</th>
                        <th class="col-sm-2">Data Cadastro</th>
                        <th class="col-sm-2">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($assuntos as $assunto)
                        <tr>
                            <td>{{ $assunto->codAs }}</td>
                            <td>
                                <strong>{{ $assunto->descricao }}</strong>
                                @if($assunto->livros_count > 0)
                                    <br>
                                    <small class="text-muted">
                                        Livros:
                                        @foreach($assunto->livros->take(3) as $livro)
                                            <span class="badge badge-light">{{ $livro->titulo }}</span>
                                        @endforeach
                                        @if($assunto->livros_count > 3)
                                            <span class="text-muted">+{{ $assunto->livros_count - 3 }} mais</span>
                                        @endif
                                    </small>
                                @endif
                            </td>
                            <td>
                            <span class="badge {{ $assunto->livros_count > 0 ? 'badge-success' : 'badge-secondary' }} badge-pill">
                                {{ $assunto->livros_count }} livro(s)
                            </span>
                            </td>
                            <td>{{ $assunto->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('assuntos.edit', $assunto->codAs) }}"
                                       class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('assuntos.destroy', $assunto->codAs) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-excluir"
                                                title="Excluir"
                                                onclick="excluir(event, this.form, 'Excluir Assunto?', 'Deseja realmente excluir o assunto <b>{{ $assunto->descricao }}</b>?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Nenhum assunto cadastrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $assuntos->appends(request()->query())->links() }}

            @if($assuntos->count() > 0)
                <div class="mt-2 text-muted">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        Total de {{ $assuntos->total() }} assunto(s) encontrado(s)
                    </small>
                </div>
            @endif
        </div>
    </div>
@endsection
