<?php

namespace App\Http\Controllers\administration\User;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Exception;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración cuenta de usuario
    |----------------------------------------------------------------------------------------------------
    */

    public function getAccount(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('getAccount');

        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        try {
            $account = User::with('roles')
                ->select('users.*')
                ->where('uuid', $validatedData['uuid'])
                ->firstOrFail();

            $userData = [
                'uuid' => $account->uuid,
                'name' => $account->name,
                'email' => $account->email,
                'role' => optional($account->roles->first())->name ?? 'N/A',
                'department' => $account->department->name,
                'position' => $account->position->name,
                'is_active' => $account->is_active,
                'last_login' => $account->last_login,
                'phone' => $account->phone,
                'notes' => $account->notes,
                'created_at' => date('d-m-Y H:i:s', strtotime($account->created_at)),
            ];

            return $this->shared->sendResponse($userData, $this->shared->getDataMessage(), Response::HTTP_OK);
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Error', Response::HTTP_BAD_REQUEST);
        }
    }

    public function editAccount(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('editAccount');

        $validatedData = $request->validate([
            'name'  => 'required|string|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'required|min:5|max:2147483647',
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        try {
            $account = User::where('uuid', $validatedData['uuid'])->firstOrFail();
            $account->name = $this->shared->clearString($validatedData['name']);
            $account->phone = $validatedData['phone'];
            $account->notes = $validatedData['notes'];
            $account->updated_at = Carbon::now();
            $account->save();

            $userData = [
                'name' => $account->name,
                'phone' => $account->phone,
                'notes' => $account->notes,
            ];

            return $this->shared->sendResponse($userData, 'Cuenta Actualizada con éxito!', Response::HTTP_OK);
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Sucesio un problema intente nuevamente.', Response::HTTP_BAD_REQUEST);
        }
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración de usuarios
    |----------------------------------------------------------------------------------------------------
    */

    public function listUser()
    {
        $userData = [];
        $users = User::with('roles', 'department', 'position')
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        foreach ($users as $user) {
            $userData[] = [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department->name,
                'position' => $user->position->name,
                'is_active' => $user->is_active,
                'phone' => $user->phone,
                'notes' => $user->notes,
                'last_login' => isNull($user->last_login) ? 'N/A' : date('d-m-Y H:i:s', strtotime($user->last_login)),
                'role' => optional($user->roles->first())->name ?? 'N/A',
                'created_at' => date('d-m-Y', strtotime($user->created_at)),
                'updated_at' => date('d-m-Y', strtotime($user->updated_at))
            ];
        }

        return $this->shared->sendResponse($userData, 'Catalogo de cuentas de usuarios!', Response::HTTP_OK);
    }

    public function createUser(Request $request, User $user)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('createUser');

        $validatedData = $request->validate([
            'name'  => 'required|string|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => ['required', 'min:5', 'max:255', 'regex:/^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/i', 'unique:users', function ($attribute, $value, $fail) {
                if ($value === strtoupper($value)) {
                    $fail('El correo electrónico no puede estar todo en mayúsculas.');
                }
            }],
            'department_id' => 'required|integer|exists:departments,id',
            'position_id' => 'required|integer|exists:positions,id',
            'phone' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'required|min:3|max:2147483647',
            // 'role' => 'required|integer|exists:roles,id',
            'password' => 'required|min:5|max:25|confirmed',
            'password_confirmation' => 'required|min:5|max:25',
        ]);

        try {

            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $this->shared->clearString($validatedData['name']),
                'email' => $validatedData['email'],
                'department_id' => $validatedData['department_id'],
                'position_id' => $validatedData['position_id'],
                'is_active' => true,
                'last_login' => null,
                'phone' => $validatedData['phone'],
                'notes' => $validatedData['notes'],
                // 'role' => optional($request->roles->first())->name ?? 'N/A',
                'password' => Hash::make($validatedData['password'])
            ]);

            User::created($user);

            return $this->shared->sendResponse($user, 'Usuario registrado.', Response::HTTP_CREATED);
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function deatailUser(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deatailUser');

        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        try {
            $user = User::where('uuid', $validatedData['uuid'])
                ->firstOrFail();
            $user->load('roles');

            $userData = [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department->name,
                'position' => $user->position->name,
                'is_active' => $user->is_active,
                'last_login' => $user->last_login,
                'phone' => $user->phone,
                'notes' => $user->notes,
                'role' => optional($user->roles->first())->name ?? 'N/A',
                'created_at' => $user->created_at->format('d-m-Y H:i:s'),
            ];

            return $this->shared->sendResponse($userData, 'Deatail user.', Response::HTTP_OK);
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function editUser(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('editAccount');

        $validatedData = $request->validate([
            'name'  => 'required|string|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'phone' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'required|min:5|max:2147483647',
            'department_id' => 'required|integer|exists:departments,id',
            'position_id' => 'required|integer|exists:positions,id',
            'uuid' => 'required|string|uuid|exists:users,uuid',
            
        ]);

        try {
            $account = User::where('uuid', $validatedData['uuid'])->firstOrFail();
            $account->name = $this->shared->clearString($validatedData['name']);
            $account->phone = $validatedData['phone'];
            $account->notes = $validatedData['notes'];
            $account->department_id = $validatedData['department_id'];
            $account->position_id = $validatedData['position_id'];
            $account->updated_at = Carbon::now();
            $account->save();

            $userData = [
                'name' => $account->name,
                'phone' => $account->phone,
                'notes' => $account->notes,
                'department' => $account->department->name,
                'position' => $account->position->name,
            ];

            return $this->shared->sendResponse($userData, 'Cuenta de usuario actualizada con éxito!', Response::HTTP_OK);
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Sucesio un problema intente nuevamente.', Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteUser(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deleteUser');

        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
        ]);

        try {
            /* 
                NOTA: En estas acciones no se eliminara por completo el usuario, por temas de integridad de los datos se implementara
                el auto borrado mediante periodos de tiempos, manteniendo el registro oculto de esta forma si se decea recuperar el 
                registro simplemente eliminar la propiedad deleted_at
            */
            $user = User::where('uuid', $validatedData['uuid'])->firstOrFail();

            // Obtener el usuario autenticado
            $authenticatedUser = $request->user();

            // Comprobar si el usuario autenticado está intentando eliminarse a sí mismo
            if ($authenticatedUser->uuid === $user->uuid) {
                return $this->shared->sendError('No puedes eliminarte a ti mismo.', 403);
            }

            $user->deleted_at = Carbon::now();
            $user->is_active = false;
            $user->save();

            $userData = [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department->name,
                'position' => $user->position->name,
                'is_active' => $user->is_active,
                'phone' => $user->phone,
                'notes' => $user->notes,
                'role' => optional($user->roles->first())->name ?? 'N/A',
            ];

            return $this->shared->sendResponse($userData, 'Usuario eliminado con exito.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Problemas al intentar eliminar el registro.', 404);
        }
    }
}
