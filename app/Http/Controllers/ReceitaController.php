<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receita;

class ReceitaController extends Controller
{
    public function index()
    {
        $receitas = Receita::all();
        return view('receitas.index', compact('receitas'));
    }

    public function create()
    {
        return view('receitas.create');
    }

    public function store(Request $request)
    {
        Receita::create($request->all());
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

        return redirect('/receitas')->with('success', 'Receita atualizada!');
    }

    public function destroy($id)
    {
        Receita::destroy($id);
        return redirect('/receitas')->with('success', 'Receita excluída!');
    }
}