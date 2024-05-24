<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Rules\NormalizedExists;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    public $departments;
    public $positions;

    // Autorización
    public function __construct()
    {
        $this->departments = Department::pluck('id', 'name');
        $this->positions = Position::pluck('id', 'name');
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Importar usuarios mediante una plantilla
    |----------------------------------------------------------------------------------------------------
    */

    use Importable;

    public function rules(): array
    {
        return [
            '*.nombre_completo'  => ['required', 'string', 'min:3', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            '*.email' => ['required', 'min:5', 'max:255', 'regex:/^[A-Za-z0-9\._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/i', 'unique:users'],
            '*.departamento' => ['required', 'string', new NormalizedExists('departments', 'name')],
            '*.posicion' => ['required', 'string', new NormalizedExists('positions', 'name')],
            '*.telefono' => ['required', 'numeric'],
            '*.comentarios' => ['nullable', 'max:2147483647'],
            '*.contrasenia' => ['required', 'min:5', 'max:25'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nombre_completo.required' => 'El campo nombre es obligatorio.',
            '*.nombre_completo.string' => 'El campo nombre debe ser una cadena de texto.',
            '*.nombre_completo.min' => 'El campo nombre debe tener al menos :min caracteres.',
            '*.nombre_completo.max' => 'El campo nombre no debe superar :max caracteres.',
            '*.nombre_completo.regex' => 'El campo nombre debe contener solo letras, espacios y guiones.',

            '*.email.required' => 'El campo correo electrónico es obligatorio.',
            '*.email.min' => 'El campo correo electrónico debe tener al menos :min caracteres.',
            '*.email.max' => 'El campo correo electrónico no debe superar :max caracteres.',
            '*.email.regex' => 'El campo correo electrónico debe ser válido y tener un formato correcto.',
            '*.email.unique' => 'El correo electrónico ya está en uso.',

            '*.departamento.required' => 'El campo departamento paterno es obligatorio.',
            '*.departamento.string' => 'El campo departamento paterno debe ser una cadena de texto.',
            '*.departamento.exists' => 'El campo departamento debe existir en los registros del sistema.',

            '*.posicion.required' => 'El campo posicion paterno es obligatorio.',
            '*.posicion.string' => 'El campo posicion paterno debe ser una cadena de texto.',
            '*.posicion.exists' => 'El campo posicion debe existir en los registros del sistema.',

            '*.telefono.required' => 'El campo telefono es obligatorio.',
            '*.telefono.numeric' => 'El campo telefono debe ser un valor numerico.',

            '*.contrasenia.required' => 'El campo contraseña es obligatorio.',
            '*.contrasenia.min' => 'El campo contraseña debe tener al menos :min caracteres.',
            '*.contrasenia.max' => 'El campo contraseña no debe superar :max caracteres.',
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $indice => $row) {
            $user = new User;
            $user->uuid = Str::uuid();
            $user->name = $this->clearString($row['nombre_completo']);
            $user->email = trim($row['email']);
            $user->department_id = isset($this->departments[$row['departamento']]) ? $this->departments[$row['departamento']] : 1;
            $user->position_id = isset($this->positions[$row['posicion']]) ? $this->positions[$row['posicion']] : 1;
            $user->is_active = 1; // Valor por defecto
            $user->phone = $row['telefono'];
            $user->notes = $row['comentarios'];
            $user->password = trim(Hash::make($row['contrasenia']));
            $user->save();
            $user->assignRole('Empleado');
        }

        unset($rows[$indice]);
    }

    public static function clearString($texto, $lower = false)
    {
        $texto = Str::ascii($texto);
        $texto = trim($texto);
        $texto = $lower == true ? strtoupper($texto) : strtolower($texto);

        return $texto;
    }
}
