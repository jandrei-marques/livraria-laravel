@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Estatísticas -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalLivros }}</h3>
                        <p>Total de Livros</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="{{ route('livros.index') }}" class="small-box-footer">
                        Ver detalhes <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>R$ {{ number_format($valorTotalLivros, 2, ',', '.') }}</h3>
                        <p>Valor Total em Livros</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('livros.index') }}" class="small-box-footer">
                        Ver detalhes <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalAutores }}</h3>
                        <p>Autores Cadastrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <a href="{{ route('autores.index') }}" class="small-box-footer">
                        Ver detalhes <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalAssuntos }}</h3>
                        <p>Assuntos Cadastrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="{{ route('assuntos.index') }}" class="small-box-footer">
                        Ver detalhes <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Livros Recentes -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock mr-1"></i>
                            Livros Recentes
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $livrosRecentes->count() }} livros</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @forelse($livrosRecentes as $livro)
                                <li class="item">
                                    <div class="product-img">
                                        <i class="fas fa-book fa-2x text-blue"></i>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('livros.show', $livro->codl) }}" class="product-title">
                                            {{ $livro->titulo }}
                                            <span class="badge badge-info float-right">R$ {{ number_format($livro->valor, 2, ',', '.') }}</span>
                                        </a>
                                        <span class="product-description">
                                    {{ $livro->editora }} - {{ $livro->anoPublicacao }}
                                    <br>
                                    <small class="text-muted">
                                        Assuntos:
                                        @foreach($livro->assuntos as $assunto)
                                            <span class="badge badge-light">{{ $assunto->descricao }}</span>
                                        @endforeach
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        Autores:
                                        @foreach($livro->autores as $autor)
                                            <span class="badge badge-secondary">{{ $autor->nome }}</span>
                                        @endforeach
                                    </small>
                                </span>
                                    </div>
                                </li>
                            @empty
                                <li class="item">
                                    <div class="product-info">
                                <span class="product-description text-muted">
                                    Nenhum livro cadastrado recentemente.
                                </span>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('livros.index') }}" class="uppercase">Ver Todos os Livros</a>
                    </div>
                </div>
            </div>

            <!-- Autores Mais Populares -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Autores Mais Populares
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($autoresPopulares as $autor)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>{{ $autor->nome }}</div>
                                        <div>
                                            <span class="badge badge-success badge-pill">
                                                {{ $autor->total_livros }} livro(s)
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center">
                                    Nenhum autor com livros cadastrados.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('autores.index') }}" class="uppercase">Ver Todos os Autores</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Assuntos Mais Comuns -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tags mr-1"></i>
                            Assuntos Mais Comuns
                        </h3>
                    </div>
                    <div class="card-body">
                        @forelse($assuntosComuns as $assunto)
                            <div class="progress-group">
                                {{ Str::limit($assunto->descricao, 25) }}
                                <span class="float-right">
                            <b>{{ $assunto->total_livros }}</b>/{{ $totalLivros }}
                        </span>
                                <div class="progress progress-sm">
                                    @php
                                        $percent = $totalLivros > 0 ? ($assunto->total_livros / $totalLivros) * 100 : 0;
                                    @endphp
                                    <div class="progress-bar bg-primary" style="width: {{ $percent }}%"></div>
                                </div>
                                <small class="text-muted">
                                    {{ number_format($percent, 1) }}% dos livros
                                </small>
                            </div>
                            @if(!$loop->last)
                                <hr class="my-2">
                            @endif
                        @empty
                            <p class="text-muted text-center">Nenhum assunto com livros cadastrados.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Livros Mais Caros -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-crown mr-1"></i>
                            Livros Mais Valiosos
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Valor</th>
                                    <th>Autores</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($livrosMaisCaros as $livro)
                                    <tr>
                                        <td>
                                            <a href="{{ route('livros.show', $livro->codl) }}">
                                                {{ Str::limit($livro->titulo, 20) }}
                                            </a>
                                        </td>
                                        <td>
                                        <span class="badge bg-success">
                                            R$ {{ number_format($livro->valor, 2, ',', '.') }}
                                        </span>
                                        </td>
                                        <td>
                                            @foreach($livro->autores->take(2) as $autor)
                                                <small class="badge badge-light">{{ Str::limit($autor->nome, 15) }}</small>
                                            @endforeach
                                            @if($livro->autores->count() > 2)
                                                <small class="text-muted">+{{ $livro->autores->count() - 2 }}</small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Nenhum livro cadastrado.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Editoras Populares -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building mr-1"></i>
                            Editoras em Destaque
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($editorasPopulares as $editora)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                    <span class="font-weight-bold">
                                        {{ $editora->editora ?: 'Sem editora' }}
                                    </span>
                                        </div>
                                        <div>
                                    <span class="badge badge-warning badge-pill">
                                        {{ $editora->total_livros }} livro(s)
                                    </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center">
                                    Nenhuma editora com livros cadastrados.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Livros por Ano -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Livros por Ano (Últimos 5 anos)
                        </h3>
                    </div>
                    <div class="card-body">
                        @forelse($livrosPorAno as $ano)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="font-weight-bold">{{ $ano->anoPublicacao }}</span>
                                <span class="badge badge-info">{{ $ano->total }} livro(s)</span>
                            </div>
                        @empty
                            <p class="text-muted text-center">Nenhum livro nos últimos 5 anos.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumo por Assunto -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Resumo por Assunto
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($assuntosComuns as $assunto)
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-tag"></i>
                                </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ Str::limit($assunto->descricao, 15) }}</span>
                                            <span class="info-box-number">{{ $assunto->total_livros }}</span>
                                            <div class="progress">
                                                @php
                                                    $percent = $totalLivros > 0 ? ($assunto->total_livros / $totalLivros) * 100 : 0;
                                                @endphp
                                                <div class="progress-bar" style="width: {{ $percent }}%"></div>
                                            </div>
                                            <span class="progress-description">
                                        {{ number_format($percent, 1) }}% do total
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Ações Rápidas
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 col-6">
                                <a href="{{ route('livros.create') }}" class="btn btn-app bg-success">
                                    <i class="fas fa-plus"></i>
                                    Novo Livro
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="{{ route('autores.create') }}" class="btn btn-app bg-info">
                                    <i class="fas fa-user-plus"></i>
                                    Novo Autor
                                </a>
                            </div>
                            <div class="col-md-3 col-6">
                                <a href="{{ route('assuntos.create') }}" class="btn btn-app bg-warning">
                                    <i class="fas fa-tag"></i>
                                    Novo Assunto
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .products-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .products-list > .item {
            border-radius: 0.25rem;
            background: #f8f9fa;
            padding: 10px 0;
            margin: 5px 0;
        }
        .product-img {
            float: left;
            width: 50px;
            text-align: center;
        }
        .product-info {
            margin-left: 60px;
        }
        .product-title {
            display: block;
            font-size: 1rem;
            font-weight: 600;
        }
        .product-description {
            display: block;
            color: #6c757d;
            font-size: 0.875rem;
        }
        .btn-app {
            border-radius: 3px;
            position: relative;
            padding: 15px 5px;
            margin: 0 0 10px 10px;
            min-width: 80px;
            height: 60px;
            text-align: center;
            color: #fff;
            border: 1px solid #ddd;
            background-color: #f4f4f4;
            font-size: 12px;
        }
        .btn-app > .fas {
            font-size: 20px;
            display: block;
        }
        .progress-group {
            margin-bottom: 0.5rem;
        }
    </style>
@endpush
