<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';
    protected $primaryKey = 'codAu';
    public $timestamps = true;

    protected $fillable = [
        'nome'
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_autor', 'codAu', 'codl');
    }

    public function getTotalLivrosAttribute()
    {
        return $this->livros()->count();
    }
}
