@extends('layouts.app')

@section('title', 'Editar Livro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('livros.index') }}">Livros</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Livro: {{ $livro->titulo }}</h3>
        </div>
        <form action="{{ route('livros.update', $livro->codl) }}" method="POST" id="livroForm">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('components.form.input', [
                            'name' => 'titulo',
                            'label' => 'Título',
                            'value' => old('titulo', $livro->titulo),
                            'placeholder' => 'Digite o título do livro',
                            'maxlength' => 40,
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.form.input', [
                            'name' => 'editora',
                            'label' => 'Editora',
                            'value' => old('editora', $livro->editora),
                            'placeholder' => 'Digite a editora',
                            'maxlength' => 40,
                            'required' => true
                        ])
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        @include('components.form.input', [
                            'name' => 'edicao',
                            'label' => 'Edição',
                            'value' => old('edicao', $livro->edicao),
                            'placeholder' => 'Ex: 1',
                            'class' => 'edicao-mask',
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-3">
                        @include('components.form.input', [
                            'name' => 'anoPublicacao',
                            'label' => 'Ano Publicação',
                            'value' => old('anoPublicacao', $livro->anoPublicacao),
                            'placeholder' => 'AAAA',
                            'class' => 'year-mask',
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-3">
                        @include('components.form.input', [
                            'name' => 'valor',
                            'label' => 'Valor (R$)',
                            'value' => old('valor', 'R$ ' . number_format($livro->valor, 2, ',', '.')),
                            'placeholder' => 'R$ 0,00',
                            'class' => 'money-mask',
                            'required' => true
                        ])
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                <div class="form-group">
                    <label for="assuntos">Assuntos *</label>
                    <select class="form-control select2-multiple @error('assuntos') is-invalid @enderror"
                            id="assuntos" name="assuntos[]" multiple="multiple"
                            data-placeholder="Selecione os assuntos" style="width: 100%;" required>
                        @foreach($assuntos as $assunto)
                            <option value="{{ $assunto->codAs }}"
                                {{ in_array($assunto->codAs, old('assuntos', $livro->assuntos->pluck('codAs')->toArray())) ? 'selected' : '' }}>
                                {{ $assunto->descricao }}
                            </option>
                        @endforeach
                    </select>
                    @error('assuntos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                    </div>
                    <div class="col-md-6">

                <div class="form-group">
                    <label for="autores">Autores *</label>
                    <select class="form-control select2-multiple @error('autores') is-invalid @enderror"
                            id="autores" name="autores[]" multiple="multiple"
                            data-placeholder="Selecione os autores" style="width: 100%;" required>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->codAu }}"
                                {{ in_array($autor->codAu, old('autores', $livro->autores->pluck('codAu')->toArray())) ? 'selected' : '' }}>
                                {{ $autor->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('autores')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar
                </button>
                <a href="{{ route('livros.index') }}" class="btn btn-default">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Validação customizada do formulário
            $('#livroForm').on('submit', function(e) {
                const autores = $('#autores').val();
                if (!autores || autores.length === 0) {
                    e.preventDefault();
                    alertaErro("Selecione pelo menos um autor");
                    $('#autores').focus();
                }
                const assuntos = $('#assuntos').val();
                if (!assuntos || assuntos.length === 0) {
                    e.preventDefault();
                    alertaErro("Selecione pelo menos um assunto");
                    $('#autores').focus();
                }
            });
        });
    </script>
@endpush
