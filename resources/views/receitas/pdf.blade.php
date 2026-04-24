<h1>Lista de Receitas</h1>

<table border="1" width="100%">
<tr>
    <th>Nome</th>
    <th>Tipo</th>
    <th>Custo</th>
</tr>

@foreach($receitas as $r)
<tr>
    <td>{{ $r->nome }}</td>
    <td>{{ $r->tipo_receita }}</td>
    <td>{{ $r->custo }}</td>
</tr>
@endforeach

</table>