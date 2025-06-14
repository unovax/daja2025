<?php

namespace App\Http\Controllers\Catalogs;

use App\Helpers\ResponseManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\Unit\Store;
use App\Http\Requests\Catalogs\Unit\Update;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->search);
        $perPage = $request->per_page;
        $orderBy = $request->order_by;

        $units = Unit::query();

        if ($search && $search != '') {
            $units = $units
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        }

        return $units->orderBy($orderBy ?? 'created_At', 'desc')->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        try {
            $unit = Unit::create([
                'name' => $request->name
            ]);
            return ResponseManager::success('Cliente creado correctamente', [
                'unit' => $unit
            ]);
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                throw new \Exception("Cliente no encontrado", 404);
            }
            return ResponseManager::success('Cliente obtenido correctamente', [
                'unit' => $unit
            ]);
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, string $id)
    {
        try {
            $unit = Unit::find($id);
            if(!$unit) throw new \Exception("No se encontro el cliente", 404);

            $unit->update([
                'name' => $request->name
            ]);

            return ResponseManager::success('Cliente actualizado correctamente', [
                'unit' => $unit
            ]);
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $unit = Unit::find($id);
            if (!$unit) {
                throw new \Exception("Cliente no encontrada", 404);
            }
            $unit->delete();
            return ResponseManager::success('Cliente eliminada correctamente');
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }
}
