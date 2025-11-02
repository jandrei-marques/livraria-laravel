<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssuntoController extends Controller
{
    public function index(Request $request)
    {
        $query = Assunto::withCount('livros')->with(['livros' => function($q) {
            $q->orderBy('titulo')->take(3);
        }]);

        $assuntos = $query->paginate(10);

        return view('assuntos.index', compact('assuntos'));
    }

    public function create()
    {
        return view('assuntos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:40|unique:assuntos,descricao'
        ], [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'A descrição não pode ter mais de 40 caracteres.',
            'descricao.unique' => 'Já existe um assunto com esta descrição.'
        ]);

        try {
            Assunto::create($validated);
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar assunto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Assunto $assunto)
    {
        $assunto->load(['livros' => function($query) {
            $query->with(['autores', 'assuntos'])->orderBy('titulo');
        }, 'livros.autores']);

        return view('assuntos.show', compact('assunto'));
    }

    public function edit(Assunto $assunto)
    {
        $assunto->loadCount('livros')->load(['livros' => function($query) {
           $query->orderBy('titulo')->take(5);
        }]);

        return view('assuntos.edit', compact('assunto'));
    }

    public function update(Request $request, Assunto $assunto)
    {
        $validated = $request->validate([
            'descricao' => [
                'required',
                'string',
                'max:40',
                Rule::unique('assuntos', 'descricao')->ignore($assunto->codAs, 'codAs')
            ]
        ], [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'A descrição não pode ter mais de 40 caracteres.',
            'descricao.unique' => 'Já existe um assunto com esta descrição.'
        ]);

        try {
            $assunto->update($validated);
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar assunto: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Assunto $assunto)
    {
        try {
            // Verificar se o assunto tem livros associados
            if ($assunto->livros()->count() > 0) {
                return redirect()->route('assuntos.index')
                    ->with('error', 'Não é possível excluir o assunto pois existem livros associados a ele.');
            }

            $assunto->delete();
            return redirect()->route('assuntos.index')
                ->with('success', 'Assunto excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('assuntos.index')
                ->with('error', 'Erro ao excluir assunto: ' . $e->getMessage());
        }
    }
}
