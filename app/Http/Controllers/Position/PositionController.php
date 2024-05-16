<?php

namespace App\Http\Controllers\Position;

use App\Helpers\SharedFunctionsHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Position;
use Carbon\Carbon;
use Exception;

class PositionController extends Controller
{
    protected $shared;

    // Autorización
    public function __construct(SharedFunctionsHelpers $shared)
    {
        $this->shared = $shared;
    }

    /*
    |----------------------------------------------------------------------------------------------------
    |   Administración de posiciones
    |----------------------------------------------------------------------------------------------------
    */

    public function listPosition()
    {
        try {
            $positions = Position::select('uuid', 'name', 'description', 'created_at', 'updated_at')
                ->whereNull('deleted_at')->get();

            return $this->shared->sendResponse($positions, 'Lista de posiciones recuperada con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al recuperar la lista de posiciones', $e->getMessage());
        }
    }


    public function createPosition(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'description' => 'nullable|string'
        ]);

        try {
            $posicion = Position::create([
                'uuid' => Str::uuid(),
                'name' => $this->shared->clearString($validatedData['name']),
                'description' => $validatedData['description'],
            ]);

            $posicionData = [
                'uuid' => $posicion->uuid,
                'name' => $posicion->name,
                'description' => $posicion->description
            ];

            return $this->shared->sendResponse($posicionData, 'Departamento creado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al crear el departamento', $e->getMessage());
        }
    }


    public function showPosition(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:positions,uuid',
        ]);

        try {
            $posicion = Position::where('uuid', $validatedData['uuid'])
                ->whereNull('deleted_at')
                ->firstOrFail();

            $posicionData = [
                'uuid' => $posicion->uuid,
                'name' => $posicion->name,
                'description' => $posicion->description
            ];

            return $this->shared->sendResponse($posicionData, 'Departamento encontrado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Departamento no encontrado', $e->getMessage());
        }
    }


    public function editPosition(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:positions,uuid',
            'name' => 'required|string|max:255|unique:positions,name',
            'description' => 'nullable|string'
        ]);

        try {
            $posicion = Position::where('uuid', $validatedData['uuid'])->firstOrFail();
            $posicion->update($validatedData);

            $posicionData = [
                'name' => $posicion->name,
                'description' => $posicion->description
            ];

            return $this->shared->sendResponse($posicionData, 'Departamento actualizado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al actualizar el departamento', $e->getMessage());
        }
    }


    public function deletePosition(Request $request)
    {
        $validatedData = $request->validate([
            'uuid' => 'required|string|uuid|exists:positions,uuid',
        ]);

        try {
            $posicion = Position::where('uuid', $validatedData['uuid'])->firstOrFail();
            $posicion->deleted_at = Carbon::now();
            $posicion->save();

            $posicionData = [
                'uuid' => $posicion->uuid,
                'name' => $posicion->name,
                'description' => $posicion->description
            ];

            return $this->shared->sendResponse($posicionData, 'Departamento eliminado con éxito');
        } catch (Exception $e) {
            return $this->shared->sendError('Error al eliminar el departamento', $e->getMessage());
        }
    }
}
