<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- topo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Receitas</h2>

        <div>
            <a href="/receitas/create" class="btn btn-success">
                Nova Receita
            </a>

            <a href="/logout" class="btn btn-danger">
                Sair
            </a>
        </div>
    </div>

    <!-- filtros -->
    <form method="GET" class="row g-2 mb-4">

        <!-- pesquisa nome/descricao -->
        <div class="col-md-4">
            <input 
                type="text"
                name="busca"
                value="{{ request('busca') }}"
                class="form-control"
                placeholder="Pesquisar por nome ou descrição"
            >
        </div>

        <!-- data -->
        <div class="col-md-3">
            <input 
                type="date" 
                name="data" 
                value="{{ request('data') }}"
                class="form-control"
            >
        </div>

        <!-- tipo -->
        <div class="col-md-3">
            <select name="tipo" class="form-select">
                <option value="">Todos</option>

                <option value="doce" {{ request('tipo') == 'doce' ? 'selected' : '' }}>
                    Doce
                </option>

                <option value="salgada" {{ request('tipo') == 'salgada' ? 'selected' : '' }}>
                    Salgada
                </option>
            </select>
        </div>

        <!-- botoes -->
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">
                Filtrar
            </button>
        </div>

        <div class="col-md-6 d-grid">
            <a href="/receitas" class="btn btn-secondary">
                Limpar
            </a>
        </div>

        <div class="col-md-6 d-grid">
            <a href="/receitas/pdf" class="btn btn-danger">
                PDF
            </a>
        </div>

    </form>

    <!-- tabela -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped table-hover mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Custo</th>
                        <th>Data</th>
                        <th width="180">Ações</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($receitas as $r)
                    <tr>
                        <td>{{ $r->nome }}</td>
                        <td>{{ $r->descricao }}</td>
                        <td>{{ ucfirst($r->tipo_receita) }}</td>
                        <td>R$ {{ number_format($r->custo, 2, ',', '.') }}</td>
                        <td>{{ date('d/m/Y', strtotime($r->data_registro)) }}</td>

                        <td>
                            <a href="/receitas/{{ $r->id }}/edit"
                               class="btn btn-warning btn-sm">
                               Editar
                            </a>

                            <form action="/receitas/{{ $r->id }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir?')">
                                    Excluir
                                </button>

                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">
                            Nenhuma receita encontrada.
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>