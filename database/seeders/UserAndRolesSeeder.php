<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Resetea la memoria caché de roles y permisos para evitar errores
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos para un sistema administrativo
        $permissions = [
            'listUsers',
            'createUser',
            'editUser',
            'detailUser',
            'deleteUser',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar los permisos (Administrador)
        $adminRole = Role::create(['name' => 'Administrador']);
        $adminRole->givePermissionTo(Permission::all());

        // Crear un departamento
        $department = Department::create([
            'uuid' => Str::uuid(),
            'name' => 'soporte tecnico',
            'description' => 'Personal de la direccion',
        ]);

        // Crear una posision
        $position = Position::create([
            'uuid' => Str::uuid(),
            'name' => 'soporte tecnico',
            'description' => 'Personal de soporte',
        ]);

        // Crear usuario Administrador
        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => 'Kharma Solutions - Admin',
            'email' => 'admin@kharma-s.com',
            'password' => Hash::make('123456'),
            'phone' => '7775944783',
            'is_active' => true,
            'department_id' => $department->id,
            'position_id' => $position->id,
        ]);

        // TODO: Eliminar en produccion
        $user['acces_token'] = $user->createToken('auth_token')->plainTextToken;
        $user['token_type'] = 'Bearer';
        $user['uuid'] = $user->uuid;

        // Asignar el rol de Administrador al usuario
        $user->assignRole($adminRole);

        // Crear roles y asignar los permisos (Empleado)
        $empleadoRol = Role::create(['name' => 'Empleado']);
        // $empleadoRol->givePermissionTo(Permission::all()); // Pendiante a crear los permisos para este rol

        // Crear usuario empleado
        /*$empleado = User::create([
            'uuid' => Str::uuid(),
            'name' => 'Angel Paredes Torres',
            'email' => 'angelparedestorres.apt@gmail.com',
            'password' => Hash::make('123456'),
            'department' => 'Sistemas',
            'position' => 'Desarrollador Full Stack',
            'phone' => '7775944783',
            'is_active' => true
        ]);*/

        // Asignar el rol de Administrador al usuario
        // $empleado->assignRole($empleadoRol);
    }
}
