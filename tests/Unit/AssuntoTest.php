<?php

namespace Tests\Unit;

use App\Models\Assunto;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssuntoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_um_assunto()
    {
        $assunto = Assunto::factory()->create([
            'descricao' => 'Ficção Científica'
        ]);

        $this->assertInstanceOf(Assunto::class, $assunto);
        $this->assertEquals('Ficção Científica', $assunto->descricao);
        $this->assertDatabaseHas('assuntos', [
            'descricao' => 'Ficção Científica'
        ]);
    }

    /** @test */
    public function assunto_pode_ter_muitos_livros()
    {
        $assunto = Assunto::factory()->create();
        $livro1 = Livro::factory()->create();
        $livro2 = Livro::factory()->create();

        $assunto->livros()->attach([$livro1->codl, $livro2->codl]);

        $this->assertCount(2, $assunto->livros);
        $this->assertInstanceOf(Livro::class, $assunto->livros->first());
    }

    /** @test */
    public function descricao_do_assunto_e_obrigatoria()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Assunto::factory()->create(['descricao' => null]);
    }

    /** @test */
    public function descricao_nao_pode_ter_mais_de_40_caracteres()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Assunto::factory()->create([
            'descricao' => str_repeat('a', 41)
        ]);
    }

    /** @test */
    public function descricao_do_assunto_deve_ser_unica()
    {
        Assunto::factory()->create(['descricao' => 'Assunto Duplicado']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Assunto::factory()->create(['descricao' => 'Assunto Duplicado']);
    }

    /** @test */
    public function pode_calcular_total_de_livros_vinculados()
    {
        $assunto = Assunto::factory()->create();
        $livro1 = Livro::factory()->create();
        $livro2 = Livro::factory()->create();

        $assunto->livros()->attach([$livro1->codl, $livro2->codl]);

        $this->assertEquals(2, $assunto->getTotalLivrosAttribute());
    }
}
