<?php

namespace Database\Seeders;

use App\Models\Autor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autores = [
            ['Nome' => 'Machado de Assis'],
            ['Nome' => 'Clarice Lispector'],
            ['Nome' => 'Jorge Amado'],
            ['Nome' => 'Carlos Drummond de Andrade'],
            ['Nome' => 'Cecília Meireles'],
            ['Nome' => 'Lygia Fagundes Telles'],
            ['Nome' => 'Rubem Fonseca'],
            ['Nome' => 'Paulo Coelho'],
            ['Nome' => 'Ariano Suassuna'],
            ['Nome' => 'Conceição Evaristo'],
            ['Nome' => 'George Orwell'],
            ['Nome' => 'J.K. Rowling'],
            ['Nome' => 'Stephen King'],
            ['Nome' => 'Agatha Christie'],
            ['Nome' => 'Isaac Asimov'],
        ];

        foreach ($autores as $autor) {
            Autor::create($autor);
        }

        $this->command->info('Autores criados com sucesso!');
    }
}
