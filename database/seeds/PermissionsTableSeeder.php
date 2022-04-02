<?php
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Navegar Usuarios',
            'slug' => 'usuario.index'
        ]);
        Permission::create([
            'name' => 'crear Usuarios',
            'slug' => 'usuario.crear'
        ]);
        Permission::create([
            'name' => 'editar Usuarios',
            'slug' => 'usuario.editar'
        ]);
        Permission::create([
            'name' => 'ver Usuarios',
            'slug' => 'usuario.ver'
        ]);
        Permission::create([
            'name' => 'activar Usuarios',
            'slug' => 'usuario.activar'
        ]);
        Permission::create([
            'name' => 'desactivar Usuarios',
            'slug' => 'usuario.desactivar'
        ]);
        Permission::create([
            'name' => 'Navegar Roles',
            'slug' => 'rol.index'
        ]);
    }
}
