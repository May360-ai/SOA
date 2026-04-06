<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Autor;

class LibroController extends Controller
{
    public function index()
    {
        if (request()->wantsJson() || request()->ajax()) {
            $q = request('q');
            return response()->json(Libro::with('autor')->when($q, function ($query) use ($q) {
                return $query->where('titulo', 'like', "%$q%");
            })->get());
        }
        return view('libros');
    }

    public function store(Request $request)
    {
        $l = Libro::create($request->all());
        return response()->json($l->load('autor'));
    }

    public function show(Libro $codigo) { return response()->json($codigo->load('autor')); }
    public function edit(Libro $codigo) { return response()->json($codigo); }

    public function update(Request $request, Libro $codigo)
    {
        $codigo->update($request->all());
        return response()->json($codigo->load('autor'));
    }

    public function destroy(Libro $codigo)
    {
        $codigo->delete();
        return response()->json(['res' => 'ok']);
    }
}
