<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Validation\ValidationException;
use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class AuthController extends Controller
{
    protected $shared;

    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => 'required|string|min:3|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => ['required', 'min:5', 'max:255', 'regex:/^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/i', 'unique:users', function ($attribute, $value, $fail) {
                if ($value === strtoupper($value)) {
                    $fail('El correo electrónico no puede estar todo en mayúsculas.');
                }
            }],
            'department' => 'required|integer|in:1,2,3,4,5,6',
            'position' => 'required|integer|in:1,2,3,4,5,6',
            'phone' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'notes' => 'required|min:3|max:2147483647',
            // 'role' => 'required|integer|exists:roles,id',
            'password' => 'required|min:5|max:25|confirmed',
            'password_confirmation' => 'required|min:5|max:25',
        ]);
        
        try {
            // Crear el usuario y almacenar en la base de datos
            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $this->shared->clearString($validatedData['name']),
                'email' => $validatedData['email'],
                'is_active' => true,
                'last_login' => null,
                'phone' => $validatedData['phone'],
                'notes' => $validatedData['notes'],
                'password' => Hash::make($validatedData['password']),
                'department_id' => $validatedData['department_id'],
                'position_id' => $validatedData['position_id']
            ]);

            $user['acces_token'] = $user->createToken('auth_token')->plainTextToken;
            $user['token_type'] = 'Bearer';
            $user['uuid'] = $user->uuid;

            // PENDIENTE A DESARROLLAR
            // $email = $user->email;
            // Mail::to($email)->send(new RegisterAccountMail($user));

            return $this->shared->sendResponse($user, $this->shared->getDataMessage(), Response::HTTP_CREATED);
        } catch (Exception $error) {
            return $this->shared->sendError($this->shared->getDataMessageError(), ['error_detail' => $error->getMessage()]);
        }
    }

    // Método para iniciar sesión
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::with('roles')
                ->select('users.*')
                ->where('email', $validatedData['email'])
                ->firstOrFail();
            
            if (!$user->is_active) {
                $userLogin = [
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'status' => $user->is_active
                ];
                return $this->shared->sendResponse($userLogin, 'Usuario inactivo.', Response::HTTP_LOCKED);
            }

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales que ingreso son incorrectas, intente nuevamente'],
                ]);
            }
            
            $token = $user->createToken('auth_token')->plainTextToken;

            // Actualizar la fecha de inicio de session
            $user->last_login = Carbon::now();
            $user->save();

            $userData = [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'role' => optional($user->roles->first())->name ?? 'N/A',
                'department' => $user->department->name,
                'position' => $user->position->name,
                'is_active' => $user->is_active,
                'last_login' => $user->last_login,
                'phone' => $user->phone,
                'access_token' =>  $token,
                'token_type' => 'Bearer',
                'created_at' => date('d-m-Y H:i:s', strtotime($user->created_at)),
            ];
            
            return $this->shared->sendResponse($userData, 'Acceso completado con exito.', Response::HTTP_ACCEPTED);
        } catch (Exception $error) {
            return $this->shared->sendError($this->shared->messageRegisterError(), ['error_detail' => $error->getMessage()]);
        }
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $user = $request->user()->currentAccessToken()->delete();

        return $this->shared->sendResponse($user, 'Se cerro la session.', Response::HTTP_ACCEPTED);
    }
}