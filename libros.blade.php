@extends('layouts.app')
@section('title', 'Libros AJAX')

@section('content')
    <form id="form" onsubmit="save(event)">
        @csrf <div id="method"></div>
        <input type="text" id="codigo" name="codigo" placeholder="Código" required>
        <input type="text" id="titulo" name="titulo" placeholder="Título" required>
        <select id="autor_dni" name="autor_dni" required>
            <option value="">Autor...</option>
            @foreach(\App\Models\Autor::all() as $a) <option value="{{ $a->dni }}">{{ $a->nombre }}</option> @endforeach
        </select>
        <button type="submit" id="btn">Guardar</button>
    </form>
    <input type="text" id="buscar" placeholder="Buscar por título..." onkeyup="reload()">
    <hr>
    <table border="1"><tbody id="tabla"></tbody></table>

    <script>
        const reload = () => {
            let q = document.getElementById('buscar').value;
            fetch(`/libros?q=${q}`, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('tabla').innerHTML = data.map(l => `
                        <tr>
                            <td>${l.codigo} - ${l.titulo} (${l.autor.nombre})</td>
                            <td>
                                <button onclick="edit('${l.codigo}')">Editar</button>
                                <button onclick="del('${l.codigo}')">Borrar</button>
                            </td>
                        </tr>`).join('');
                });
        }

        const save = (e) => {
            e.preventDefault();
            let fd = new FormData(e.target);
            let url = document.getElementById('method').innerHTML ? `/libros/${document.getElementById('codigo').value}` : '/libros';
            fetch(url, { method: 'POST', body: fd }).then(reload).then(() => e.target.reset());
        }

        const edit = (id) => fetch(`/libros/${id}/edit`).then(r => r.json()).then(data => {
            document.getElementById('method').innerHTML = '@method("PUT")';
            document.getElementById('codigo').value = data.codigo;
            document.getElementById('codigo').readOnly = true;
            document.getElementById('titulo').value = data.titulo;
            document.getElementById('autor_dni').value = data.autor_dni;
            document.getElementById('btn').innerText = "Actualizar";
        });

        const del = (id) => {
            if(!confirm('¿Borrar?')) return;
            let fd = new FormData(); fd.append('_method', 'DELETE'); fd.append('_token', '{{csrf_token()}}');
            fetch(`/libros/${id}`, { method: 'POST', body: fd }).then(reload);
        }

        reload();
    </script>
@endsection
