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

    public function listaUsuarios()
    {
        $users = User::with('roles')->select('users.*')->orderByDesc('id')->get();
        
        $users->transform(function ($user) {
            return [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department,
                'position' => $user->position,
                'is_active' => $user->is_active,
                // 'last_login' => $user->last_login,
                'phone' => $user->phone,
                // 'notes' => $user->notes,
                'role' => $user->roles->first()->name ?? 'N/A',
                'created_at' => $user->created_at,
            ];
        });

        return $this->shared->sendResponse($users, 'Lista de usuarios.');
    }

    public function listUser(User $users)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('listUser');

        try {
            return view('pages.system.users.list');
        } catch (Exception $error) {
            return redirect()->route('dashboard')->with('error', $error->getMessage());
        }
    }

    public function deatailUser($uuid)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deatailUser');

        try {
            $user = User::where('uuid', $uuid)->firstOrFail();

            return $this->shared->sendResponse($user, 'Deatail user.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage());
        }
    }

    public function deleteUser(Request $request)
    {
        # Politica para saber si el usuario cuenta con los permisos deacuerdo a su rol asignado
        // Gate::authorize('deleteUser');

        $this->validate($request, [
            'uuid' => 'required|string|exists:users,uuid',
        ]);

        try {
            $user = User::findOrFail($request->uuid);

            return $this->shared->sendResponse($user, 'Usuario eliminado con exito.');
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Usuario eliminado con exito.', 404);
        }
    }
}
