<?php

namespace App\Http\Controllers\Department;

use App\Exports\DepartmentsExport;
use Illuminate\Validation\ValidationException;
use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DepartmentsImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
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
            $departments = $this->getListDepartments();

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

    public function importDepartments(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'uuid' => 'required|string|uuid|exists:users,uuid',
                'file' => 'required|file|mimes:xlsx,csv|max:204800'
            ]);

            $user = User::where('uuid', $validatedData['uuid'])->firstOrFail();

            // Obtener el usuario autenticado
            $authenticatedUser = $request->user();

            if ($authenticatedUser->uuid != $user->uuid) {
                return $this->shared->sendError('No cuentas con los permisos para importar el catalogo de departamentos.', Response::HTTP_BAD_REQUEST);
            }

            set_time_limit(0);

            Excel::import(new DepartmentsImport, request()->file('file'));
            return $this->shared->sendResponse([], 'Catalogo importado con exito.');
        } catch (ValidationException $e) {
            return $this->shared->sendError('Errores de validación', $e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $error) {
            return $this->shared->sendError('Problemas al intentar importar el catalogo.', $error->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function exportDepartments(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:users,uuid',
            'format' => 'required|string|in:pdf,excel,csv'
        ]);

        $user = User::where('uuid', $validatedData['uuid'])->firstOrFail();

        // Obtener el usuario autenticado
        $authenticatedUser = $request->user();

        if ($authenticatedUser->uuid != $user->uuid) {
            return $this->shared->sendError('No cuentas con los permisos para exportar el catalogo de usuarios.', Response::HTTP_BAD_REQUEST);
        }

        set_time_limit(0);
        try {
            switch ($request->format) {
                case 'pdf':
                    $departments = $this->getListDepartments();

                    $pdf = PDF::loadView('reports.pdf.lists_departments', compact('departments'))
                        ->setPaper('a4')
                        ->setOption("isPhpEnabled", true)
                        ->setOption('margin-top', 5)
                        ->setOption('margin-bottom', 5);

                    return $pdf->download('Catalogo_de_departamentos_' . date('d_m_Y', strtotime(now())) . '.pdf');
                case 'excel':
                    return Excel::download(
                        new DepartmentsExport,
                        'Catalogo_de_departamentos_' . date('d_m_Y', strtotime(now())) . '.xlsx',
                        \Maatwebsite\Excel\Excel::XLSX
                    );
                    break;
                case 'csv':
                    return Excel::download(
                        new DepartmentsExport,
                        'Catalogo_de_departamentos_' . date('d_m_Y', strtotime(now())) . '.csv',
                        \Maatwebsite\Excel\Excel::CSV
                    );
                    break;

                default:
                    return Excel::download(
                        new DepartmentsExport,
                        'Catalogo_de_departamentos_' . date('d_m_Y', strtotime(now())) . '.xlsx',
                        \Maatwebsite\Excel\Excel::XLSX
                    );
                    break;
            }
        } catch (Exception $error) {
            return $this->shared->sendError($error->getMessage(), 'Problemas al intentar exportar el documento.', Response::HTTP_BAD_REQUEST);
        }
    }

    public function getListDepartments()
    {
        $departments = Department::select('uuid', 'name', 'description', 'created_at', 'updated_at')
                ->whereNull('deleted_at')->get();
        
        return $departments;
    }
}
