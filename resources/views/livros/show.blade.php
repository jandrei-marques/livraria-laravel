@extends('layouts.app')

@section('title', 'Detalhes do Livro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('livros.index') }}">Livros</a></li>
    <li class="breadcrumb-item active">Detalhes</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalhes do Livro</h3>
            <div class="card-tools">
                <a href="{{ route('livros.edit', $livro->codl) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Código:</th>
                            <td>{{ $livro->codl }}</td>
                        </tr>
                        <tr>
                            <th>Título:</th>
                            <td>{{ $livro->titulo }}</td>
                        </tr>
                        <tr>
                            <th>Editora:</th>
                            <td>{{ $livro->editora }}</td>
                        </tr>
                        <tr>
                            <th>Edição:</th>
                            <td>{{ $livro->edicao }}ª Edição</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Ano Publicação:</th>
                            <td>{{ $livro->anoPublicacao }}</td>
                        </tr>
                        <tr>
                            <th>Valor:</th>
                            <td>R$ {{ number_format($livro->valor, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Data Cadastro:</th>
                            <td>{{ $livro->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Última Atualização:</th>
                            <td>{{ $livro->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="card-title text-white">
                                <i class="fas fa-tags"></i> Assuntos
                            </h4>
                        </div>
                        <div class="card-body">
                            @foreach($livro->assuntos as $assunto)
                                <span class="badge badge-primary badge-lg mb-2 p-2">
                                {{ $assunto->descricao }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4 class="card-title text-white">
                                <i class="fas fa-user-edit"></i> Autores
                            </h4>
                        </div>
                        <div class="card-body">
                            @foreach($livro->autores as $autor)
                                <span class="badge badge-info badge-lg mb-2 p-2">
                                {{ $autor->nome }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('livros.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
@endsection
