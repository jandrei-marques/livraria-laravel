<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';
    protected $primaryKey = 'codl';
    public $timestamps = true;

    protected $fillable = [
        'titulo',
        'editora',
        'edicao',
        'anoPublicacao',
        'valor'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'edicao' => 'integer',
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'livro_autor', 'codl', 'codAu');
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'livro_assunto', 'codl', 'codAs');
    }
}
