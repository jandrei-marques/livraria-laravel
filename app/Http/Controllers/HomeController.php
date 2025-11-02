<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $totalLivros = Livro::count();
        $totalAutores = Autor::count();
        $totalAssuntos = Assunto::count();
        $valorTotalLivros = Livro::sum('Valor');


        $livrosRecentes = Livro::with(['assuntos', 'autores'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $autoresPopulares = DB::table('autores')
            ->join('livro_autor', 'autores.codAu', '=', 'livro_autor.codAu')
            ->select('autores.codAu', 'autores.nome', DB::raw('COUNT(livro_autor.codl) as total_livros'))
            ->groupBy('autores.codAu', 'autores.nome')
            ->orderBy('total_livros', 'desc')
            ->take(5)
            ->get();


        $assuntosComuns = DB::table('assuntos')
            ->join('livro_assunto', 'assuntos.codAs', '=', 'livro_assunto.codAs')
            ->select('assuntos.codAs', 'assuntos.descricao', DB::raw('COUNT(livro_assunto.Codl) as total_livros'))
            ->groupBy('assuntos.codAs', 'assuntos.descricao')
            ->orderBy('total_livros', 'desc')
            ->take(5)
            ->get();


        $livrosMaisCaros = Livro::with(['assuntos', 'autores'])
            ->orderBy('valor', 'desc')
            ->take(5)
            ->get();


        $editorasPopulares = DB::table('livros')
            ->select('editora', DB::raw('COUNT(*) as total_livros'))
            ->groupBy('editora')
            ->orderBy('total_livros', 'desc')
            ->take(5)
            ->get();


        $livrosPorAno = DB::table('livros')
            ->select('anoPublicacao', DB::raw('COUNT(*) as total'))
            ->where('anoPublicacao', '>=', date('Y') - 5)
            ->groupBy('anoPublicacao')
            ->orderBy('anoPublicacao', 'desc')
            ->get();

        return view('home', compact(
            'totalLivros',
            'totalAutores',
            'totalAssuntos',
            'valorTotalLivros',
            'livrosRecentes',
            'autoresPopulares',
            'assuntosComuns',
            'livrosMaisCaros',
            'editorasPopulares',
            'livrosPorAno'
        ));
    }
}
