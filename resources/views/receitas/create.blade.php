<!DOCTYPE html>
<html>
<head>
    <title>Nova Receita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h2>Nova Receita</h2>

    <form method="POST" action="/receitas">
        @csrf

        <input name="nome" class="form-control mb-2" placeholder="Nome" required>

        <textarea name="descricao" class="form-control mb-2" placeholder="Descrição"></textarea>

        <input type="date" name="data_registro" class="form-control mb-2">

        <input type="number" step="0.01" name="custo" class="form-control mb-2" placeholder="Custo">

        <select name="tipo_receita" class="form-control mb-2">
            <option value="doce">Doce</option>
            <option value="salgada">Salgada</option>
        </select>

        <button class="btn btn-success">Salvar</button>
        <a href="/receitas" class="btn btn-secondary">Voltar</a>
    </form>
</div>

</body>
</html>