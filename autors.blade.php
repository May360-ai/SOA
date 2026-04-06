@extends('layouts.app')
@section('title', 'Autores AJAX')

@section('content')
    <form id="form" onsubmit="save(event)">
        @csrf <div id="method"></div>
        <input type="text" id="dni" name="dni" placeholder="DNI" required>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
        <input type="text" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad" required>
        <button type="submit" id="btn">Guardar</button>
    </form>
    <input type="text" id="buscar" placeholder="Buscar por nombre..." onkeyup="reload()">
    <hr>
    <table border="1"><tbody id="tabla"></tbody></table>
    <ul id="lista"></ul>

    <script>
        const reload = () => {
            let q = document.getElementById('buscar').value;
            fetch(`/autores?q=${q}`, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('tabla').innerHTML = data.map(a => `
                        <tr>
                            <td>${a.dni} - ${a.nombre} (${a.nacionalidad})</td>
                            <td>
                                <button onclick="ver('${a.dni}')">Ver</button>
                                <button onclick="edit('${a.dni}')">Editar</button>
                                <button onclick="del('${a.dni}')">Borrar</button>
                            </td>
                        </tr>`).join('');
                });
        }

        const save = (e) => {
            e.preventDefault();
            let fd = new FormData(e.target);
            let url = document.getElementById('method').innerHTML ? `/autores/${document.getElementById('dni').value}` : '/autores';
            fetch(url, { method: 'POST', body: fd }).then(reload).then(() => e.target.reset());
        }

        const edit = (dni) => fetch(`/autores/${dni}/edit`).then(r => r.json()).then(data => {
            document.getElementById('method').innerHTML = '@method("PUT")';
            document.getElementById('dni').value = data.dni;
            document.getElementById('dni').readOnly = true;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('nacionalidad').value = data.nacionalidad;
            document.getElementById('btn').innerText = "Actualizar";
        });

        const del = (dni) => confirm('¿Borrar?') && fetch(`/autores/${dni}`, {
            method: 'POST', body: new FormData() 
        }).then(r => {
            let fd = new FormData(); fd.append('_method', 'DELETE'); fd.append('_token', '{{csrf_token()}}');
            return fetch(`/autores/${dni}`, { method: 'POST', body: fd });
        }).then(reload);

        const ver = (dni) => fetch(`/autores/${dni}`).then(r => r.json()).then(data => {
            document.getElementById('lista').innerHTML = data.libros.map(l => `<li>${l.titulo}</li>`).join('');
        });

        reload();
    </script>
@endsection
