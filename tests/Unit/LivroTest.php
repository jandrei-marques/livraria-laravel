<?php

namespace Tests\Unit;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pode_criar_um_livro()
    {
        $livro = Livro::factory()->create([
            'titulo' => 'Dom Casmurro',
            'editora' => 'Editora ABC',
            'edicao' => 1,
            'anoPublicacao' => '1899',
            'valor' => 49.90
        ]);

        $this->assertInstanceOf(Livro::class, $livro);
        $this->assertEquals('Dom Casmurro', $livro->titulo);
        $this->assertEquals(49.90, $livro->valor);
        $this->assertDatabaseHas('livros', [
            'titulo' => 'Dom Casmurro'
        ]);
    }

    /** @test */
    public function livro_pode_ter_muitos_autores()
    {
        $livro = Livro::factory()->create();
        $autor1 = Autor::factory()->create();
        $autor2 = Autor::factory()->create();

        $livro->autores()->attach([$autor1->codAu, $autor2->codAu]);

        $this->assertCount(2, $livro->autores);
        $this->assertInstanceOf(Autor::class, $livro->autores->first());
    }

    /** @test */
    public function livro_pode_ter_muitos_assuntos()
    {
        $livro = Livro::factory()->create();
        $assunto1 = Assunto::factory()->create();
        $assunto2 = Assunto::factory()->create();

        $livro->assuntos()->attach([$assunto1->codAs, $assunto2->codAs]);

        $this->assertCount(2, $livro->assuntos);
        $this->assertInstanceOf(Assunto::class, $livro->assuntos->first());
    }

    /** @test */
    public function titulo_do_livro_e_obrigatorio()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Livro::factory()->create(['titulo' => null]);
    }

    /** @test */
    public function valor_do_livro_deve_ser_positivo()
    {
        $livro = Livro::factory()->create(['valor' => 25.50]);

        $this->assertGreaterThan(0, $livro->valor);
    }

    /** @test */
    public function pode_obter_assuntos_como_texto()
    {
        $livro = Livro::factory()->create();
        $assunto1 = Assunto::factory()->create(['descricao' => 'Romance']);
        $assunto2 = Assunto::factory()->create(['descricao' => 'Ficção']);

        $livro->assuntos()->attach([$assunto1->codAs, $assunto2->codAs]);

        $this->assertEquals('Romance, Ficção', $livro->assuntos_texto);
    }

    /** @test */
    public function edicao_deve_ser_inteiro_positivo()
    {
        $livro = Livro::factory()->create(['edicao' => 3]);

        $this->assertIsInt($livro->edicao);
        $this->assertGreaterThan(0, $livro->edicao);
    }
}
