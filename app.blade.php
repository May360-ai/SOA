<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudio Laravel - @yield('title')</title>
</head>
<body>
    <nav>
        <a href="{{ route('autores.index') }}">Autores</a> | 
        <a href="{{ route('libros.index') }}">Libros</a>
    </nav>
    <hr>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif


    @yield('content')

</body>
</html>
