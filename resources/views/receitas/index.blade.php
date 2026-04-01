<!DOCTYPE html>
<html>
<head>
    <title>Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between">
        <h2>Receitas</h2>
        <div>
            <a href="/receitas/create" class="btn btn-success">Nova Receita</a>
            <a href="/logout" class="btn btn-danger">Sair</a>
        </div>
    </div>

    <table class="table table-striped mt-3">

        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Custo</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach($receitas as $r)
            <tr>
                <td>{{ $r->nome }}</td>
                <td>{{ $r->descricao }}</td>
                <td>{{ $r->tipo_receita }}</td>
                <td>R$ {{ $r->custo }}</td>
                <td>
                    <a href="/receitas/{{ $r->id }}/edit" class="btn btn-warning btn-sm">Editar</a>

                    <form action="/receitas/{{ $r->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

</body>
</html>