<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::withCount('usuarios')->orderBy('nombre')->get();

        return view('sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['nullable', 'string', 'max:20'],
        ]);

        Sucursal::create($datos);

        return redirect()->route('sucursales.index')
            ->with('status', 'Sucursal registrada correctamente.');
    }

    public function cambiarEstado(Sucursal $sucursal)
    {
        $sucursal->update(['activo' => !$sucursal->activo]);

        return redirect()->route('sucursales.index')
            ->with('status', 'Estado de la sucursal actualizado.');
    }
}