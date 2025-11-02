<?php

namespace Database\Seeders;

use App\Models\Livro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livros = [
            [
                'Titulo' => 'Dom Casmurro',
                'Editora' => 'Editora Garnier',
                'Edicao' => 1,
                'AnoPublicacao' => '1899',
                'Valor' => 45.90,
                'autores' => [1], // Machado de Assis
                'assuntos' => [1, 7] // Romance, Contos
            ],
            [
                'Titulo' => 'A Hora da Estrela',
                'Editora' => 'Editora Rocco',
                'Edicao' => 3,
                'AnoPublicacao' => '1977',
                'Valor' => 39.50,
                'autores' => [2], // Clarice Lispector
                'assuntos' => [1, 6] // Romance, Poesia
            ],
            [
                'Titulo' => 'Capitães da Areia',
                'Editora' => 'Editora Record',
                'Edicao' => 5,
                'AnoPublicacao' => '1937',
                'Valor' => 52.00,
                'autores' => [3], // Jorge Amado
                'assuntos' => [1, 9] // Romance, História
            ],
            [
                'Titulo' => 'Alguma Poesia',
                'Editora' => 'Editora Pindorama',
                'Edicao' => 2,
                'AnoPublicacao' => '1930',
                'Valor' => 35.00,
                'autores' => [4], // Carlos Drummond
                'assuntos' => [6] // Poesia
            ],
            [
                'Titulo' => 'Romanceiro da Inconfidência',
                'Editora' => 'Editora Nova Fronteira',
                'Edicao' => 4,
                'AnoPublicacao' => '1953',
                'Valor' => 48.75,
                'autores' => [5], // Cecília Meireles
                'assuntos' => [6, 9] // Poesia, História
            ],
            [
                'Titulo' => 'As Meninas',
                'Editora' => 'Editora Companhia das Letras',
                'Edicao' => 3,
                'AnoPublicacao' => '1973',
                'Valor' => 55.20,
                'autores' => [6], // Lygia Fagundes Telles
                'assuntos' => [1, 4] // Romance, Suspense
            ],
            [
                'Titulo' => '1984',
                'Editora' => 'Editora Secker & Warburg',
                'Edicao' => 8,
                'AnoPublicacao' => '1949',
                'Valor' => 42.80,
                'autores' => [11], // George Orwell
                'assuntos' => [2, 10] // Ficção Científica, Filosofia
            ],
            [
                'Titulo' => 'Harry Potter e a Pedra Filosofal',
                'Editora' => 'Editora Rocco',
                'Edicao' => 12,
                'AnoPublicacao' => '1997',
                'Valor' => 39.90,
                'autores' => [12], // J.K. Rowling
                'assuntos' => [3, 14] // Fantasia, Juvenil
            ],
            [
                'Titulo' => 'O Iluminado',
                'Editora' => 'Editora Doubleday',
                'Edicao' => 6,
                'AnoPublicacao' => '1977',
                'Valor' => 58.00,
                'autores' => [13], // Stephen King
                'assuntos' => [5, 4] // Terror, Suspense
            ],
            [
                'Titulo' => 'Assassinato no Expresso Oriente',
                'Editora' => 'Editora Collins Crime Club',
                'Edicao' => 7,
                'AnoPublicacao' => '1934',
                'Valor' => 44.50,
                'autores' => [14], // Agatha Christie
                'assuntos' => [4] // Suspense
            ],
            [
                'Titulo' => 'Fundação',
                'Editora' => 'Editora Gnome Press',
                'Edicao' => 5,
                'AnoPublicacao' => '1951',
                'Valor' => 49.90,
                'autores' => [15], // Isaac Asimov
                'assuntos' => [2] // Ficção Científica
            ],
            [
                'Titulo' => 'Memórias Póstumas de Brás Cubas',
                'Editora' => 'Editora Garnier',
                'Edicao' => 3,
                'AnoPublicacao' => '1881',
                'Valor' => 47.30,
                'autores' => [1], // Machado de Assis
                'assuntos' => [1, 10] // Romance, Filosofia
            ],
            [
                'Titulo' => 'O Alquimista',
                'Editora' => 'Editora Rocco',
                'Edicao' => 15,
                'AnoPublicacao' => '1988',
                'Valor' => 36.80,
                'autores' => [8], // Paulo Coelho
                'assuntos' => [1, 12] // Romance, Autoajuda
            ],
            [
                'Titulo' => 'O Auto da Compadecida',
                'Editora' => 'Editora Agir',
                'Edicao' => 4,
                'AnoPublicacao' => '1955',
                'Valor' => 41.20,
                'autores' => [9], // Ariano Suassuna
                'assuntos' => [1, 7] // Romance, Contos
            ],
            [
                'Titulo' => 'Ponciá Vicêncio',
                'Editora' => 'Editora Mazza',
                'Edicao' => 2,
                'AnoPublicacao' => '2003',
                'Valor' => 38.90,
                'autores' => [10], // Conceição Evaristo
                'assuntos' => [1, 8] // Romance, Biografia
            ],
        ];

        foreach ($livros as $livroData) {
            $autores = $livroData['autores'];
            $assuntos = $livroData['assuntos'];

            unset($livroData['autores'], $livroData['assuntos']);

            $livro = Livro::create($livroData);

            // Associar autores
            $livro->autores()->attach($autores);

            // Associar assuntos
            $livro->assuntos()->attach($assuntos);
        }

        $this->command->info('Livros criados com sucesso!');
    }
}
