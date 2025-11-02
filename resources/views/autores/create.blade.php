@extends('layouts.app')

@section('title', 'Cadastrar Autor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('autores.index') }}">Autores</a></li>
    <li class="breadcrumb-item active">Cadastrar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cadastrar Novo Autor</h3>
        </div>
        <form action="{{ route('autores.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome do Autor *</label>
                    <input type="text" class="form-control @error('Nome') is-invalid @enderror"
                           id="nome" name="nome" value="{{ old('nome') }}"
                           placeholder="Digite o nome do autor" maxlength="40" required>
                    @error('Nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="{{ route('autores.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
