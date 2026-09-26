<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sucursalCentral = Sucursal::firstOrCreate(
            ['nombre' => 'Tienda Central'],
            ['direccion' => 'Av. Principal 123', 'telefono' => '987654321']
        );

        $sucursalNorte = Sucursal::firstOrCreate(
            ['nombre' => 'Sucursal Norte'],
            ['direccion' => 'Av. Norte 456', 'telefono' => '987654322']
        );

        $usuarios = [
            ['admin@cams.com', 'administrador', $sucursalCentral->id],
            ['jefe@cams.com', 'jefe', $sucursalCentral->id],
            ['almacen@cams.com', 'encargado_almacen', $sucursalCentral->id],
            ['tienda@cams.com', 'encargado_tienda', $sucursalNorte->id],
        ];

        foreach ($usuarios as [$username, $rol, $sucursalId]) {
            Usuario::firstOrCreate(
                ['username' => $username],
                [
                    'password_hash' => bcrypt('cams2026'),
                    'rol' => $rol,
                    'sucursal_id' => $sucursalId,
                    'activo' => true,
                ]
            );
        }
    }
}