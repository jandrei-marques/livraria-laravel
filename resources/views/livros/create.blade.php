@extends('layouts.app')

@section('title', 'Cadastrar Livro')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('livros.index') }}">Livros</a></li>
    <li class="breadcrumb-item active">Cadastrar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cadastrar Novo Livro</h3>
        </div>
        <form action="{{ route('livros.store') }}" method="POST" id="livroForm">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('components.form.input', [
                            'name' => 'titulo',
                            'label' => 'Título',
                            'value' => old('titulo'),
                            'placeholder' => 'Digite o título do livro',
                            'maxlength' => 40,
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-6">
                        @include('components.form.input', [
                            'name' => 'editora',
                            'label' => 'Editora',
                            'value' => old('editora'),
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
                            'value' => old('edicao'),
                            'placeholder' => 'Ex: 1',
                            'class' => 'edicao-mask',
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-3">
                        @include('components.form.input', [
                            'name' => 'anoPublicacao',
                            'label' => 'Ano Publicação',
                            'value' => old('anoPublicacao'),
                            'placeholder' => 'AAAA',
                            'class' => 'year-mask',
                            'required' => true
                        ])
                    </div>
                    <div class="col-md-3">
                        @include('components.form.input', [
                            'name' => 'valor',
                            'label' => 'Valor (R$)',
                            'value' => old('valor'),
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
                                    data-placeholder="Selecione os assuntos" required>
                                @foreach($assuntos as $assunto)
                                    <option value="{{ $assunto->codAs }}"
                                        {{ in_array($assunto->codAs, old('assuntos', [])) ? 'selected' : '' }}>
                                        {{ $assunto->descricao }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assuntos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <small class="form-text text-muted">
                                Selecione um ou mais assuntos.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="autores">Autores *</label>
                            <select class="form-control select2-multiple @error('autores') is-invalid @enderror"
                                    id="autores" name="autores[]" multiple="multiple"
                                    data-placeholder="Selecione os autores" required>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor->codAu }}"
                                        {{ in_array($autor->codAu, old('autores', [])) ? 'selected' : '' }}>
                                        {{ $autor->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('autores')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <small class="form-text text-muted">
                                Selecione um ou mais autores.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cadastrar
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
            $('#livroForm').on('submit', function(e) {
                let isValid = true;
                const assuntos = $('#assuntos').val();
                const autores = $('#autores').val();

                // Validar assuntos
                if (!assuntos || assuntos.length === 0) {
                    $('#assuntos').next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#assuntos').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }

                // Validar autores
                if (!autores || autores.length === 0) {
                    $('#autores').next('.select2-container').find('.select2-selection').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#autores').next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }

                if (!isValid) {
                    e.preventDefault();
                    alertaErro("Selecione pelo menos um assunto e um autor");
                    return false;
                }
            });

            // Remover validação quando o usuário selecionar algo
            $('#assuntos').on('change', function() {
                if ($(this).val().length > 0) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            });

            $('#autores').on('change', function() {
                if ($(this).val().length > 0) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            });

            // Validação em tempo real do ano
            $('.year-mask').on('blur', function() {
                const year = $(this).val();
                const currentYear = new Date().getFullYear();

                if (year && (year < 1000 || year > currentYear)) {
                    alertaErro("Informe um ano válido");
                    $(this).focus();
                }
            });
        });
    </script>
@endpush
