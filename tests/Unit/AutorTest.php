<?php

namespace Tests\Unit;

use App\Models\Autor;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_um_autor()
    {
        $autor = Autor::factory()->create([
            'nome' => 'Machado de Assis'
        ]);

        $this->assertInstanceOf(Autor::class, $autor);
        $this->assertEquals('Machado de Assis', $autor->nome);
        $this->assertDatabaseHas('autores', [
            'nome' => 'Machado de Assis'
        ]);
    }

    /** @test */
    public function autor_pode_ter_muitos_livros()
    {
        $autor = Autor::factory()->create();
        $livro1 = Livro::factory()->create();
        $livro2 = Livro::factory()->create();

        $autor->livros()->attach([$livro1->codl, $livro2->codl]);

        $this->assertCount(2, $autor->livros);
        $this->assertInstanceOf(Livro::class, $autor->livros->first());
    }

    /** @test */
    public function nome_do_autor_e_obrigatorio()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Autor::factory()->create(['nome' => null]);
    }

    /** @test */
    public function nome_do_autor_nao_pode_ter_mais_de_40_caracteres()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Autor::factory()->create([
            'nome' => str_repeat('a', 41)
        ]);
    }

    /** @test */
    public function nome_do_autor_deve_ser_unico()
    {
        Autor::factory()->create(['nome' => 'Autor Duplicado']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Autor::factory()->create(['nome' => 'Autor Duplicado']);
    }
}
