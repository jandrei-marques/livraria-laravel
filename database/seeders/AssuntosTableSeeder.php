<?php

namespace Database\Seeders;

use App\Models\Assunto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssuntosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assuntos = [
            ['Descricao' => 'Romance'],
            ['Descricao' => 'Ficção Científica'],
            ['Descricao' => 'Fantasia'],
            ['Descricao' => 'Suspense'],
            ['Descricao' => 'Terror'],
            ['Descricao' => 'Poesia'],
            ['Descricao' => 'Contos'],
            ['Descricao' => 'Biografia'],
            ['Descricao' => 'História'],
            ['Descricao' => 'Filosofia'],
            ['Descricao' => 'Psicologia'],
            ['Descricao' => 'Autoajuda'],
            ['Descricao' => 'Infantil'],
            ['Descricao' => 'Juvenil'],
            ['Descricao' => 'Acadêmico'],
        ];

        foreach ($assuntos as $assunto) {
            Assunto::create($assunto);
        }

        $this->command->info('Assuntos criados com sucesso!');
    }
}
