<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assuntos';
    protected $primaryKey = 'codAs';
    public $timestamps = true;

    protected $fillable = [
        'descricao',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'livro_assunto', 'codAs', 'codl');
    }

    public function getTotalLivrosAttribute()
    {
        return $this->livros()->count();
    }
}
