@extends('layouts.app')

@section('title', 'Cadastrar Assunto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assuntos.index') }}">Assuntos</a></li>
    <li class="breadcrumb-item active">Cadastrar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cadastrar Novo Assunto</h3>
        </div>
        <form action="{{ route('assuntos.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="descricao">Descrição *</label>
                    <input type="text" class="form-control @error('descricao') is-invalid @enderror"
                           id="descricao" name="descricao" value="{{ old('descricao') }}"
                           placeholder="Digite o assunto" maxlength="40" required>
                    @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <a href="{{ route('assuntos.index') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
