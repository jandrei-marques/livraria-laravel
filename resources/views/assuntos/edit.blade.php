@extends('layouts.app')

@section('title', 'Editar Assunto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assuntos.index') }}">Assuntos</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Assunto: {{ $assunto->descricao }}</h3>
                </div>
                <form action="{{ route('assuntos.update', $assunto->codAs) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="descricao">Descrição do Assunto *</label>
                            <input type="text" class="form-control @error('descricao') is-invalid @enderror"
                                   id="descricao" name="descricao" value="{{ old('descricao', $assunto->descricao) }}"
                                   placeholder="Digite a descrição do assunto" maxlength="40" required>
                            @error('descricao')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <small class="form-text text-muted">
                                Máximo de 40 caracteres.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar
                        </button>
                        <a href="{{ route('assuntos.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Card de Informações -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Informações do Assunto
                    </h3>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Código:</strong>
                            <span class="badge badge-primary">{{ $assunto->codAs }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total de Livros:</strong>
                            <span class="badge badge-success">{{ $assunto->livros_count }} livro(s)</span>
                        </div>
                        <div class="list-group-item">
                            <strong>Data de Cadastro:</strong><br>
                            <small class="text-muted">{{ $assunto->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="list-group-item">
                            <strong>Última Atualização:</strong><br>
                            <small class="text-muted">{{ $assunto->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Validação em tempo real do campo descrição
            $('#descricao').on('input', function() {
                const descricao = $(this).val();
                if (descricao.length > 40) {
                    $(this).addClass('is-invalid');
                    $('#descricao-error').remove();
                    $(this).after('<span class="invalid-feedback" id="descricao-error"><strong>A descrição não pode ter mais de 40 caracteres.</strong></span>');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#descricao-error').remove();
                }
            });

        });
    </script>
@endpush
