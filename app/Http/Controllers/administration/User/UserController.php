<?php

namespace App\Http\Controllers\administration\User;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->shared->getUserStatus();
            return $next($request);
        });
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración cuenta de usuario
    |----------------------------------------------------------------------------------------------------
    */

    public function getAccount($uuid)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('getAccount');

        try {
            $account = User::where('uuid', $uuid)->firstOrFail();

            return view('pages.account.user.account', compact('account'));
        } catch (Exception $error) {
            return redirect()->route('dashboard')->with('error', $error->getMessage());
        }
    }

    public function editAccount(Request $request, $uuid)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('editAccount');

        $this->validate($request, [
            'name'  => 'nullable|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'phone' => 'nullable|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'nullable|min:5|max:2147483647',
        ]);

        try {
            $account = User::where('uuid', $uuid)->firstOrFail();
            $account->name = $request->name;
            $account->phone = $request->phone;
            $account->notes = $request->notes;
            $account->save();

            return $this->shared->sendResponse($account, 'Cuenta Actualizada con éxito!');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Sucesio un problema intente');
        }
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración de usuarios
    |----------------------------------------------------------------------------------------------------
    */

    public function listUser()
    {
        $users = User::with('roles')
            ->select('users.*')
            ->orderByDesc('id');

        $departments = [
            ['id' => 1, 'name' => 'Ventas'],
            ['id' => 2, 'name' => 'Recursos Humanos'],
            ['id' => 3, 'name' => 'Sistemas'],
            ['id' => 4, 'name' => 'Intendencia'],
            ['id' => 5, 'name' => 'Dirección'],
            ['id' => 6, 'name' => 'Otro']
        ];

        $positions = [
            ['id' => 1, 'name' => 'Empleado'],
            ['id' => 2, 'name' => 'Vendedor'],
            ['id' => 3, 'name' => 'Limpieza'],
            ['id' => 4, 'name' => 'Soporte Tecnico'],
            ['id' => 5, 'name' => 'Director'],
            ['id' => 6, 'name' => 'Cordinador']
        ];

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('options', function ($user) {
                    return view('pages.system.users.shared.options', ['uuid' => $user->uuid]);
                })
                ->addColumn('is_active', function ($user) {
                    return $user->is_active ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->first()->name ?? 'N/A';
                })
                ->addColumn('created_at', function ($user) {
                    return date('d-m-Y H:i:s', strtotime($user->created_at));
                })
                ->rawColumns(['options', 'is_active'])
                ->make(true);
        }

        return view('pages.system.users.list', compact('departments', 'positions'));
    }

    public function createUser(Request $request, User $user)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('createUser');

        $this->validate($request, [
            'name'  => 'required|string|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => ['required', 'min:5', 'max:255', 'regex:/^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/i', 'unique:users', function ($attribute, $value, $fail) {
                if ($value === strtoupper($value)) {
                    $fail('El correo electrónico no puede estar todo en mayúsculas.');
                }
            }],
            'department' => 'required|integer|in:1,2,3,4,5,6',
            'position' => 'required|integer|in:1,2,3,4,5,6',
            'phone' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'required|min:5|max:2147483647',
            // 'role' => 'required|integer|exists:roles,id',
            'password' => 'required|min:5|max:25|confirmed',
            'password_confirmation' => 'required|min:5|max:25',
        ]);

        try {

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'department' => $request->department,
                'position' => $request->position,
                'is_active' => true,
                'phone' => $request->phone,
                'notes' => $request->notes,
                // 'role' => optional($request->roles->first())->name ?? 'N/A',
            ];


            User::created($userData);

            return $this->shared->sendResponse($userData, 'Deatail user.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage());
        }
    }

    public function deatailUser($uuid)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deatailUser');

        try {
            $user = User::with('roles')
                ->select('users.*')
                ->where('uuid', $uuid)
                ->first();

            $userData = [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department,
                'position' => $user->position,
                'is_active' => $user->is_active,
                'last_login' => $user->last_login,
                'phone' => $user->phone,
                'notes' => $user->notes,
                'role' => optional($user->roles->first())->name ?? 'N/A',
                'created_at' => date('d-m-Y H:i:s', strtotime($user->created_at)),
            ];

            return $this->shared->sendResponse($userData, 'Deatail user.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage());
        }
    }

    public function deleteUser(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deleteUser');
        return $this->shared->sendResponse([], 'Usuario eliminado con exito.');
        $this->validate($request, [
            'uuid' => 'required|string|exists:users,uuid',
        ]);

        try {
            $user = User::where('uuid', $request->uuid)->first();
            $user->delete();

            return $this->shared->sendResponse($user, 'Usuario eliminado con exito.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Problemas al intentar eliminar el registro.', 404);
        }
    }
}
