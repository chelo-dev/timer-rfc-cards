<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\Department;

class DepartmentsImport implements ToCollection, WithHeadingRow, WithValidation
{
    /*
    |----------------------------------------------------------------------------------------------------
    |   Importar usuarios mediante una plantilla
    |----------------------------------------------------------------------------------------------------
    */

    use Importable;

    public function rules(): array
    {
        return [
            '*.nombre'  => ['required', 'string', 'unique:departments,name', 'min:3', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            '*.descripcion' => ['nullable', 'max:2147483647'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nombre.required' => 'El campo nombre es obligatorio.',
            '*.nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            '*.nombre.min' => 'El campo nombre debe tener al menos :min caracteres.',
            '*.nombre.max' => 'El campo nombre no debe superar :max caracteres.',
            '*.nombre.unique' => 'El campo nombre ya se encuentra registrado en el sistema.',

            '*.descripcion.max' => 'El campo correo electrónico no debe superar :max caracteres.',
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $indice => $row) {
            $department = new Department;
            $department->uuid = Str::uuid();
            $department->name = $this->clearString($row['nombre']);
            $department->description = trim($row['descripcion']);
            $department->save();
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
