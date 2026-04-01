<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark d-flex justify-content-center align-items-center vh-100">

<form method="POST" action="/login" class="bg-white p-4 rounded shadow" style="width:300px;">
    @csrf

    <h4 class="mb-3 text-center">Login</h4>

    <input type="text" name="login" class="form-control mb-2" placeholder="Login" required>
    <input type="password" name="senha" class="form-control mb-2" placeholder="Senha" required>

    <button class="btn btn-primary w-100">Entrar</button>

    @if(session('erro'))
        <div class="text-danger mt-2">{{ session('erro') }}</div>
    @endif
</form>

</body>
</html>