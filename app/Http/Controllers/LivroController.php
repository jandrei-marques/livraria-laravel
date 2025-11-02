<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LivroController extends Controller
{
    public function index(Request $request)
    {
        $query = Livro::with(['assuntos', 'autores']);

        $livros = $query->orderBy('titulo')->paginate(10);
        $autores = Autor::orderBy('nome')->get();
        $assuntos = Assunto::orderBy('descricao')->get();
        return view('livros.index', compact('livros', 'autores', 'assuntos'));
    }

    public function create()
    {
        $autores = Autor::orderBy('nome')->get();
        $assuntos = Assunto::orderBy('descricao')->get();
        return view('livros.create', compact('autores', 'assuntos'));
    }

    public function store(Request $request)
    {
        $valor = floatval(trim(str_replace(['R$', '.', ','], ['', '', '.'], $request->valor)));
        $validated = $request->validate([
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'anoPublicacao' => 'required|digits:4|date_format:Y',
            'assuntos' => 'required|array|min:1',
            'assuntos.*' => 'exists:assuntos,codAs',
            'autores' => 'required|array|min:1',
            'autores.*' => 'exists:autores,codAu'
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'editora.required' => 'O campo editora é obrigatório.',
            'edicao.required' => 'O campo edição é obrigatório.',
            'edicao.min' => 'A edição deve ser pelo menos 1.',
            'anoPublicacao.required' => 'O campo ano de publicação é obrigatório.',
            'anoPublicacao.digits' => 'O ano deve ter 4 dígitos.',
            'anoPublicacao.date_format' => 'Informe um ano válido.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'assuntos.required' => 'Selecione pelo menos um assunto.',
            'assuntos.min' => 'Selecione pelo menos um assunto.',
            'autores.required' => 'Selecione pelo menos um autor.',
            'autores.min' => 'Selecione pelo menos um autor.'
        ]);

        try {

            if (!is_numeric($valor) || floatval($valor) <= 0) {
                return redirect()->back()
                    ->with('error', 'Por favor, informe um valor numérico válido maior que zero.')
                    ->withInput();
            }
            $validated['valor'] = $valor;
            $livro = Livro::create($validated);

            // Associar assuntos
            $livro->assuntos()->sync($validated['assuntos']);

            // Associar autores
            $livro->autores()->sync($validated['autores']);

            return redirect()->route('livros.index')
                ->with('success', 'Livro cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar livro: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Livro $livro)
    {
        $livro->load(['assuntos', 'autores']);
        return view('livros.show', compact('livro'));
    }

    public function edit(Livro $livro)
    {
        $autores = Autor::orderBy('nome')->get();
        $assuntos = Assunto::orderBy('descricao')->get();
        $livro->load(['assuntos', 'autores']);

        return view('livros.edit', compact('livro', 'autores', 'assuntos'));
    }

    public function update(Request $request, Livro $livro)
    {
        $valor = floatval(trim(str_replace(['R$', '.', ','], ['', '', '.'], $request->valor)));

        $validated = $request->validate([
            'titulo' => 'required|string|max:40',
            'editora' => 'required|string|max:40',
            'edicao' => 'required|integer|min:1',
            'anoPublicacao' => 'required|digits:4|date_format:Y',
            'assuntos' => 'required|array|min:1',
            'assuntos.*' => 'exists:assuntos,codAs',
            'autores' => 'required|array|min:1',
            'autores.*' => 'exists:autores,codAu'
        ], [
            'titulo.required' => 'O campo título é obrigatório.',
            'editora.required' => 'O campo editora é obrigatório.',
            'edicao.required' => 'O campo edição é obrigatório.',
            'edicao.min' => 'A edição deve ser pelo menos 1.',
            'anoPublicacao.required' => 'O campo ano de publicação é obrigatório.',
            'anoPublicacao.digits' => 'O ano deve ter 4 dígitos.',
            'anoPublicacao.date_format' => 'Informe um ano válido.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'assuntos.required' => 'Selecione pelo menos um assunto.',
            'assuntos.min' => 'Selecione pelo menos um assunto.',
            'autores.required' => 'Selecione pelo menos um autor.',
            'autores.min' => 'Selecione pelo menos um autor.'
        ]);

        try {
            if (!is_numeric($valor) || floatval($valor) <= 0) {
                return redirect()->back()
                    ->with('error', 'Por favor, informe um valor numérico válido maior que zero.')
                    ->withInput();
            }
            $validated['valor'] = $valor;

            $livro->update($validated);

            // Atualizar assuntos
            $livro->assuntos()->sync($validated['assuntos']);

            // Atualizar autores
            $livro->autores()->sync($validated['autores']);

            return redirect()->route('livros.index')
                ->with('success', 'Livro atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar livro: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Livro $livro)
    {
        try {
            $livro->assuntos()->detach();
            $livro->autores()->detach();
            $livro->delete();

            return redirect()->route('livros.index')
                ->with('success', 'Livro excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('livros.index')
                ->with('error', 'Erro ao excluir livro: ' . $e->getMessage());
        }
    }
}
