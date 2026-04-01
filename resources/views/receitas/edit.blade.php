<!DOCTYPE html>
<html>
<head>
    <title>Editar Receita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    
    <h2>Editar Receita</h2>

    <form method="POST" action="/receitas/{{ $receita->id }}">
        @csrf
        @method('PUT')

        <label>Nome</label>
        <input 
            type="text" 
            name="nome" 
            value="{{ $receita->nome }}" 
            class="form-control mb-2" 
            required
        >

        <label>Descrição</label>
        <textarea 
            name="descricao" 
            class="form-control mb-2"
            required
        >{{ $receita->descricao }}</textarea>

        <label>Data</label>
        <input 
            type="date" 
            name="data_registro" 
            value="{{ $receita->data_registro }}" 
            class="form-control mb-2"
        >

        <label>Custo</label>
        <input 
            type="number" 
            step="0.01" 
            name="custo" 
            value="{{ $receita->custo }}" 
            class="form-control mb-2"
        >

        <label>Tipo</label>
        <select name="tipo_receita" class="form-control mb-3">
            <option value="doce" {{ $receita->tipo_receita == 'doce' ? 'selected' : '' }}>Doce</option>
            <option value="salgada" {{ $receita->tipo_receita == 'salgada' ? 'selected' : '' }}>Salgada</option>
        </select>

        <button class="btn btn-primary">Atualizar</button>
        <a href="/receitas" class="btn btn-secondary">Voltar</a>

    </form>

</div>

</body>
</html>