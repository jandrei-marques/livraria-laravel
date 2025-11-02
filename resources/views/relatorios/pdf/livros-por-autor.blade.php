<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório - Livros por Autor</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { color: #2c3e50; margin: 0; }
        .header .subtitle { color: #7f8c8d; font-size: 14px; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th { background-color: #34495e; color: white; padding: 8px; text-align: left; }
        .table td { padding: 6px; border: 1px solid #ddd; }
        .table tr:nth-child(even) { background-color: #f8f9fa; }
        .autor-header { background-color: #ecf0f1 !important; font-weight: bold; padding: 8px; }
        .subtotal { background-color: #d1ecf1 !important; font-weight: bold; }
        .total { background-color: #2c3e50 !important; color: white; font-weight: bold; }
        .stats { margin: 15px 0; padding: 10px; background-color: #f8f9fa; border-radius: 5px; }
        .stats .stat-item { display: inline-block; margin-right: 20px; }
        .footer { margin-top: 30px; text-align: center; color: #7f8c8d; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge { background-color: #3498db; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px; margin: 1px; }
    </style>
</head>
<body>
<div class="header">
    <h1>Relatório - Livros por Autor</h1>
    <div class="subtitle">Sistema Livraria - {{ $dataGeracao }}</div>

    @if(isset($autorSelecionado))
        <div style="color: #e74c3c; margin-top: 10px;">
            <strong>Filtro aplicado:</strong> Autor: {{ $autorSelecionado->nome }}
        </div>
    @endif
</div>

<div class="stats">
    <div class="stat-item"><strong>Total de Livros:</strong> {{ $totalLivros }}</div>
    <div class="stat-item"><strong>Valor Total:</strong> R$ {{ number_format($valorTotal, 2, ',', '.') }}</div>
    <div class="stat-item"><strong>Autores:</strong> {{ $totalAutoresUnicos }}</div>
    <div class="stat-item"><strong>Valor Médio:</strong> R$ {{ $totalLivros > 0 ? number_format($valorTotal / $totalLivros, 2, ',', '.') : '0,00' }}</div>
</div>

<table class="table">
    <thead>
    <tr>
        <th>Autor</th>
        <th>Título</th>
        <th>Editora</th>
        <th>Edição</th>
        <th>Ano</th>
        <th>Valor</th>
        <th>Assuntos</th>
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
                    <tr class="subtotal">
                        <td colspan="5" style="text-align: right;"><strong>Subtotal {{ $autorAtual }}:</strong></td>
                        <td><strong>R$ {{ number_format($subtotalAutor, 2, ',', '.') }}</strong></td>
                        <td><strong>{{ $contadorLivrosAutor }} livro(s)</strong></td>
                    </tr>
                @endif

                @php
                    $autorAtual = $livro->autor;
                    $subtotalAutor = 0;
                    $contadorLivrosAutor = 0;
                @endphp

                <tr class="autor-header">
                    <td colspan="7">{{ $livro->autor }}</td>
                </tr>
            @endif

            <tr>
                <td>{{ $livro->autor }}</td>
                <td>{{ $livro->titulo }}</td>
                <td>{{ $livro->editora }}</td>
                <td>{{ $livro->edicao }}ª</td>
                <td>{{ $livro->anoPublicacao }}</td>
                <td>R$ {{ number_format($livro->valor, 2, ',', '.') }}</td>
                <td>
                    @foreach(explode(', ', $livro->assuntos) as $assunto)
                        <span class="badge">{{ trim($assunto) }}</span>
                    @endforeach
                </td>
            </tr>

            @php
                $subtotalAutor += $livro->valor;
                $contadorLivrosAutor++;
            @endphp
        @endforeach
    @endforeach

    @if($autorAtual !== null)
        <tr class="subtotal">
            <td colspan="5" style="text-align: right;"><strong>Subtotal {{ $autorAtual }}:</strong></td>
            <td><strong>R$ {{ number_format($subtotalAutor, 2, ',', '.') }}</strong></td>
            <td><strong>{{ $contadorLivrosAutor }} livro(s)</strong></td>
        </tr>
    @endif
    </tbody>
    <tfoot>
    <tr class="total">
        <td colspan="5" style="text-align: right;"><strong>TOTAL GERAL:</strong></td>
        <td><strong>R$ {{ number_format($valorTotal, 2, ',', '.') }}</strong></td>
        <td><strong>{{ $totalLivros }} livro(s)</strong></td>
    </tr>
    </tfoot>
</table>

<div class="footer">
    Relatório gerado em {{ $dataGeracao }} - Sistema Livraria v1.0
</div>
</body>
</html>
