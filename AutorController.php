<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function index()
    {
        if (request()->wantsJson() || request()->ajax()) {
            $q = request('q');
            return response()->json(Autor::when($q, function ($query) use ($q) {
                return $query->where('nombre', 'like', "%$q%");
            })->get());
        }
        return view('autors');
    }

    public function store(Request $request)
    {
        $a = Autor::create($request->all());
        return response()->json($a);
    }

    public function show(Autor $dni) { return response()->json($dni->load('libros')); }
    public function edit(Autor $dni) { return response()->json($dni); }

    public function update(Request $request, Autor $dni)
    {
        $dni->update($request->all());
        return response()->json($dni);
    }

    public function destroy(Autor $dni)
    {
        $dni->delete();
        return response()->json(['res' => 'ok']);
    }
}
