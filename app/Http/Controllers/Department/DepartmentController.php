<?php

namespace App\Http\Controllers\Department;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class DepartmentController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración de departamentos
    |----------------------------------------------------------------------------------------------------
    */

    public function listDepartment()
    {
        try {
            $departments = Department::select('uuid', 'name', 'description', 'created_at', 'updated_at')
                ->whereNull('deleted_at')->get();

            return $this->shared->sendResponse($departments, 'Lista de departamentos recuperada con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al recuperar la lista de departamentos', $e->getMessage());
        }
    }


    public function createDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string'
        ]);

        try {
            $department = Department::create([
                'uuid' => Str::uuid(),
                'name' => $this->shared->clearString($validatedData['name']),
                'description' => $validatedData['description'],
            ]);

            $departmentData = [
                'uuid' => $department->uuid,
                'name' => $department->name,
                'description' => $department->description
            ];

            return $this->shared->sendResponse($departmentData, 'Departamento creado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al crear el departamento', $e->getMessage());
        }
    }


    public function showDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:departments,uuid',
        ]);

        try {
            $department = Department::where('uuid', $validatedData['uuid'])
                ->whereNull('deleted_at')
                ->firstOrFail();

            $departmentData = [
                'uuid' => $department->uuid,
                'name' => $department->name,
                'description' => $department->description
            ];

            return $this->shared->sendResponse($departmentData, 'Departamento encontrado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Departamento no encontrado', $e->getMessage());
        }
    }


    public function editDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:departments,uuid',
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string'
        ]);

        try {
            $department = Department::where('uuid', $validatedData['uuid'])->firstOrFail();
            $department->update($validatedData);

            $departmentData = [
                'name' => $department->name,
                'description' => $department->description
            ];

            return $this->shared->sendResponse($departmentData, 'Departamento actualizado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al actualizar el departamento', $e->getMessage());
        }
    }


    public function deleteDepartment(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:departments,uuid',
        ]);

        try {
            $department = Department::where('uuid', $validatedData['uuid'])->firstOrFail();
            $department->deleted_at = Carbon::now();
            $department->save();

            $departmentData = [
                'uuid' => $department->uuid,
                'name' => $department->name,
                'description' => $department->description
            ];

            return $this->shared->sendResponse($departmentData, 'Departamento eliminado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al eliminar el departamento', $e->getMessage());
        }
    }
}
