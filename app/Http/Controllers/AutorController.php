<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::orderBy('nome')->paginate(10);
        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:40|unique:autores,nome'
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 40 caracteres.',
            'nome.unique' => 'Já existe um autor com este nome.'
        ]);

        try {
            Autor::create($validated);
            return redirect()->route('autores.index')
                ->with('success', 'Autor cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar autor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Autor $autor)
    {
        $autor->load(['livros' => function($query) {
            $query->with(['autores', 'assuntos'])->orderBy('titulo');
        }, 'livros.autores']);

        return view('autores.show', compact('autor'));
    }

    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(Request $request, Autor $autor)
    {
        $validated = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:40',
                Rule::unique('autores', 'nome')->ignore($autor->codAu, 'CodAu')
            ]
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 40 caracteres.',
            'nome.unique' => 'Já existe um autor com este nome.'
        ]);

        try {
            $autor->update($validated);
            return redirect()->route('autores.index')
                ->with('success', 'Autor atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar autor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Autor $autor)
    {
        try {
            // Verificar se o autor tem livros associados
            if ($autor->livros()->count() > 0) {
                return redirect()->route('autores.index')
                    ->with('error', 'Não é possível excluir o autor pois existem livros associados a ele.');
            }

            $autor->delete();
            return redirect()->route('autores.index')
                ->with('success', 'Autor excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('autores.index')
                ->with('error', 'Erro ao excluir autor: ' . $e->getMessage());
        }
    }
}
