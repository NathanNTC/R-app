<!DOCTYPE html>
<html>
<head>
    <title>Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="d-flex justify-content-between">
        <h2>Receitas</h2>
        <a href="/logout" class="btn btn-danger">Sair</a>
    </div>

    <p>Bem-vindo, {{ Auth::user()->nome }}</p>

    <table class="table table-striped mt-3">
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Custo</th>
            <th>Tipo</th>
        </tr>

        @foreach($receitas as $r)
        <tr>
            <td>{{ $r->nome }}</td>
            <td>{{ $r->descricao }}</td>
            <td>{{ $r->data_registro }}</td>
            <td>R$ {{ $r->custo }}</td>
            <td>{{ $r->tipo_receita }}</td>
        </tr>
        @endforeach
    </table>

</div>

</body>
</html>