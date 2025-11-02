@extends('layouts.app')

@section('title', 'Autores')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Autores</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Autores</h3>
            <div class="card-tools">
                <a href="{{ route('autores.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Novo Autor
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Data Cadastro</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($autores as $autor)
                    <tr>
                        <td>{{ $autor->codAu }}</td>
                        <td>{{ $autor->nome }}</td>
                        <td>{{ $autor->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('autores.edit', $autor->codAu) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('autores.destroy', $autor->codAu) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-excluir"
                                            title="Excluir"
                                            onclick="excluir(event, this.form, 'Excluir Autor?', 'Deseja realmente excluir o autor <b>{{ $autor->nome }}</b>?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Nenhum autor cadastrado.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    @if($autores->count() > 0)
                        <div class="dataTables_info">
                            <i class="fas fa-info-circle"></i>
                            Mostrando {{ $autores->firstItem() }} a {{ $autores->lastItem() }} de {{ $autores->total() }} autor(es)
                        </div>
                    @else
                        <div class="dataTables_info">
                            <i class="fas fa-info-circle"></i>
                            Nenhum autor encontrado
                        </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_paginate paging_simple_numbers float-right">
                        {{ $autores->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
