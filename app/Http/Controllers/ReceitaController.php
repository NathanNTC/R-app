<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receita;
use Illuminate\Support\Facades\Mail;

class ReceitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Receita::query();

        // pesquisar nome ou descrição
        if ($request->filled('busca')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->busca . '%')
                ->orWhere('descricao', 'like', '%' . $request->busca . '%');
            });
        }

        // filtro por data
        if ($request->filled('data')) {
            $query->whereDate('data_registro', $request->data);
        }

        // filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo_receita', $request->tipo);
        }

        $receitas = $query->get();

        return view('receitas.index', compact('receitas'));
    }

    public function create()
    {
        return view('receitas.create');
    }

    public function store(Request $request)
    {
        Receita::create($request->all());

        Mail::raw('Receita criada com sucesso!', function ($msg) {
            $msg->to('teste@teste.com')
                ->subject('Nova Receita');
        });

        return redirect('/receitas')->with('success', 'Receita criada!');
    }

    public function edit($id)
    {
        $receita = Receita::findOrFail($id);

        return view('receitas.edit', compact('receita'));
    }

    public function update(Request $request, $id)
    {
        $receita = Receita::findOrFail($id);
        $receita->update($request->all());

        Mail::raw('Receita atualizada com sucesso!', function ($msg) {
            $msg->to('teste@teste.com')
                ->subject('Receita Atualizada');
        });

        return redirect('/receitas')->with('success', 'Receita atualizada!');
    }

    public function destroy($id)
    {
        Receita::destroy($id);

        return redirect('/receitas')->with('success', 'Receita excluída!');
    }

    public function pdf()
    {
        $receitas = Receita::all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('receitas.pdf', compact('receitas'));

        return $pdf->download('receitas.pdf');
    }
}
