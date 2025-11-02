@extends('layouts.app')

@section('title', 'Livros')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Livros</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Livros</h3>
            <div class="card-tools">
                <a href="{{ route('livros.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Novo Livro
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Editora</th>
                        <th>Edição</th>
                        <th>Ano</th>
                        <th>Valor</th>
                        <th>Assuntos</th>
                        <th>Autores</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($livros as $livro)
                        <tr>
                            <td>{{ $livro->codl }}</td>
                            <td>{{ $livro->titulo }}</td>
                            <td>{{ $livro->editora }}</td>
                            <td>{{ $livro->edicao }}ª</td>
                            <td>{{ $livro->anoPublicacao }}</td>
                            <td>R$ {{ number_format($livro->valor, 2, ',', '.') }}</td>
                            <td>
                                @foreach($livro->assuntos as $assunto)
                                    <span class="badge badge-primary">{{ $assunto->descricao }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($livro->autores as $autor)
                                    <span class="badge badge-info">{{ $autor->nome }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('livros.show', $livro->codl) }}"
                                       class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('livros.edit', $livro->codl) }}"
                                       class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('livros.destroy', $livro->codl) }}" method="POST" class="d-inline" id="form-excluir-livro-{{ $livro->codl }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-excluir"
                                                title="Excluir"
                                                onclick="excluir(event, this.form, 'Excluir Livro?', 'Deseja realmente excluir o livro <b>{{ $livro->titulo }}</b>?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                @if(request()->anyFilled(['titulo', 'autor_id', 'assunto_id']))
                                    Nenhum livro encontrado com os filtros aplicados.
                                @else
                                    Nenhum livro cadastrado.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $livros->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Selecione uma opção',
                allowClear: true
            });
        });
    </script>
@endpush
