@extends('layouts.app')

@section('title', 'Relatório - Livros por Autor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Relatório - Livros por Autor</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar mr-1"></i>
                Relatório - Livros por Autor
            </h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('relatorio.excel', request()->query()) }}">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                        <a class="dropdown-item" href="{{ route('relatorio.pdf', request()->query()) }}">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </div>
                </div>
                <button type="button" class="btn btn-tool" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card-body border-bottom">
            <form action="{{ route('relatorio.livros') }}" method="GET" class="form-inline">
                <div class="row" style="width: 100%;">
                    <div class="col-md-6 mb-2">
                        <select name="autor_id" class="form-control select2-single" style="width: 100%;">
                            <option value="">Todos os autores</option>
                            @foreach($autores as $autor)
                                <option value="{{ $autor->codAu }}"
                                    {{ request('autor_id') == $autor->codAu ? 'selected' : '' }}>
                                    {{ $autor->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('relatorio.livros') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <!-- Estatísticas -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Livros</span>
                            <span class="info-box-number">{{ $totalLivros }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Valor Total</span>
                            <span class="info-box-number">R$ {{ number_format($valorTotal, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-user-edit"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Autores</span>
                            <span class="info-box-number">{{ $totalAutoresUnicos }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Valor Médio</span>
                            <span class="info-box-number">R$ {{ $totalLivros > 0 ? number_format($valorTotal / $totalLivros, 2, ',', '.') : '0,00' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($autorSelecionado))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Filtrando por autor: <strong>{{ $autorSelecionado->nome }}</strong>
                </div>
            @endif

            <!-- Tabela do Relatório -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>Autor</th>
                        <th>Título</th>
                        <th>Editora</th>
                        <th>Edição</th>
                        <th>Ano</th>
                        <th>Valor</th>
                        <th>Assuntos</th>
                        <th>Data Cadastro</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $autorAtual = null;
                        $subtotalAutor = 0;
                        $contadorLivrosAutor = 0;
                    @endphp

                    @foreach($livrosAgrupadosPorAutor as $codAutor => $livrosAutor)
                        @foreach($livrosAutor as $livro)
                            @if($autorAtual != $livro->autor)
                                @if($autorAtual !== null)
                                    <tr class="table-info">
                                        <td colspan="5" class="text-right">
                                            <strong>Subtotal {{ $autorAtual }}:</strong>
                                        </td>
                                        <td>
                                            <strong>R$ {{ number_format($subtotalAutor, 2, ',', '.') }}</strong>
                                        </td>
                                        <td colspan="2">
                                            <strong>{{ $contadorLivrosAutor }} livro(s)</strong>
                                        </td>
                                    </tr>
                                @endif

                                @php
                                    $autorAtual = $livro->autor;
                                    $subtotalAutor = 0;
                                    $contadorLivrosAutor = 0;
                                @endphp

                                <tr class="table-secondary">
                                    <td colspan="8">
                                        <strong>
                                            <i class="fas fa-user-edit"></i>
                                            {{ $livro->autor }}
                                        </strong>
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>{{ $livro->autor }}</td>
                                <td>
                                    <a href="{{ route('livros.show', $livro->codl) }}" class="text-primary">
                                        {{ $livro->titulo }}
                                    </a>
                                </td>
                                <td>{{ $livro->editora }}</td>
                                <td>{{ $livro->edicao }}ª</td>
                                <td>{{ $livro->anoPublicacao }}</td>
                                <td>R$ {{ number_format($livro->valor, 2, ',', '.') }}</td>
                                <td>
                                    @foreach(explode(', ', $livro->assuntos) as $assunto)
                                        <span class="badge badge-primary">{{ trim($assunto) }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $livro->dataCadastro->format('d/m/Y H:i') }}</td>
                            </tr>

                            @php
                                $subtotalAutor += $livro->valor;
                                $contadorLivrosAutor++;
                            @endphp
                        @endforeach
                    @endforeach

                    @if($autorAtual !== null)
                        <tr class="table-info">
                            <td colspan="5" class="text-right">
                                <strong>Subtotal {{ $autorAtual }}:</strong>
                            </td>
                            <td>
                                <strong>R$ {{ number_format($subtotalAutor, 2, ',', '.') }}</strong>
                            </td>
                            <td colspan="2">
                                <strong>{{ $contadorLivrosAutor }} livro(s)</strong>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot class="table-dark">
                    <tr>
                        <td colspan="5" class="text-right">
                            <strong>TOTAL GERAL:</strong>
                        </td>
                        <td>
                            <strong>R$ {{ number_format($valorTotal, 2, ',', '.') }}</strong>
                        </td>
                        <td colspan="2">
                            <strong>{{ $totalLivros }} livro(s)</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            @if($livrosAgrupadosPorAutor->count() == 0)
                <div class="text-center py-4">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum dado encontrado</h4>
                    <p class="text-muted">Não há livros cadastrados para os filtros selecionados.</p>
                </div>
            @endif
        </div>
        <div class="card-footer text-muted">
            <small>
                <i class="fas fa-info-circle"></i>
                Relatório gerado em {{ now()->format('d/m/Y H:i:s') }} -
                Sistema Livraria v1.0
            </small>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            .card-header, .card-footer, .breadcrumb, .main-sidebar, .main-header,
            .btn, .alert, .info-box, .border-bottom {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .table {
                font-size: 12px;
            }
            .table-secondary {
                background-color: #f8f9fa !important;
            }
            .table-info {
                background-color: #d1ecf1 !important;
            }
        }
    </style>
@endpush
