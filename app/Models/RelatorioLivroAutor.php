<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatorioLivroAutor extends Model
{

    public $timestamps = false;


    public $incrementing = false;


    protected $table = 'relatorio_livros_por_autor';


    protected $fillable = [
        'codAu',
        'autor',
        'codl',
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'valorFormatado',
        'valor',
        'assuntos',
        'totalAssuntos',
        'dataCadastro'
    ];


    protected $casts = [
        'valor' => 'decimal:2',
        'edicao' => 'integer',
        'totalAssuntos' => 'integer',
        'dataCadastro' => 'datetime'
    ];
}
