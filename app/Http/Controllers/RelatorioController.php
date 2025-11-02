<?php

namespace App\Http\Controllers;

use App\Models\RelatorioLivroAutor;
use App\Models\Autor;
use App\Exports\LivrosPorAutorExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function livrosPorAutor(Request $request)
    {
        $query = RelatorioLivroAutor::orderBy('autor')->orderBy('titulo');
        $autores = Autor::orderBy('nome')->get();


        $autorSelecionado = null;
        if ($request->has('autor_id') && $request->autor_id) {
            $query->where('CodAu', $request->autor_id);
            $autorSelecionado = Autor::find($request->autor_id);
        }

        $livrosPorAutor = $query->get();

        // Estatísticas
        $totalLivros = $livrosPorAutor->count();
        $valorTotal = $livrosPorAutor->sum('valor');
        $totalAutoresUnicos = $livrosPorAutor->unique('codAu')->count();

        // Agrupar por autor para o relatório
        $livrosAgrupadosPorAutor = $livrosPorAutor->groupBy('codAu');

        return view('relatorios.livros-por-autor', compact(
            'livrosAgrupadosPorAutor',
            'totalLivros',
            'valorTotal',
            'totalAutoresUnicos',
            'autores',
            'autorSelecionado' ?? null
        ));
    }

    public function exportarExcel(Request $request)
    {
        $autorFiltro = $request->autor_id;
        $nomeArquivo = 'relatorio_livros_por_autor_' . date('Y-m-d_H-i') . '.xlsx';

        return Excel::download(new LivrosPorAutorExport($autorFiltro), $nomeArquivo);
    }

    public function exportarPDF(Request $request)
    {
        $query = RelatorioLivroAutor::orderBy('autor')->orderBy('titulo');

        if ($request->has('autor_id') && $request->autor_id) {
            $query->where('codAu', $request->autor_id);
            $autorSelecionado = Autor::find($request->autor_id);
        }

        $livrosPorAutor = $query->get();
        $livrosAgrupadosPorAutor = $livrosPorAutor->groupBy('codAu');

        $dados = [
            'livrosAgrupadosPorAutor' => $livrosAgrupadosPorAutor,
            'totalLivros' => $livrosPorAutor->count(),
            'valorTotal' => $livrosPorAutor->sum('valor'),
            'totalAutoresUnicos' => $livrosPorAutor->unique('codAu')->count(),
            'autorSelecionado' => $autorSelecionado ?? null,
            'dataGeracao' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('relatorios.pdf.livros-por-autor', $dados);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('relatorio_livros_por_autor_' . date('Y-m-d_H-i') . '.pdf');
    }
}
