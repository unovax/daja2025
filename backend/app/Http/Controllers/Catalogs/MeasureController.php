<?php

namespace App\Http\Controllers\Catalogs;

use App\Helpers\ResponseManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\Measure\Store;
use App\Http\Requests\Catalogs\Measure\Update;
use App\Models\Measure;
use Illuminate\Http\Request;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $relations = ["unit", "client"];
    public function index(Request $request)
    {
        $search = trim($request->search);
        $perPage = $request->per_page;
        $orderBy = $request->order_by;

        $measures = Measure::with($this->relations);

        if ($search && $search != '') {
            $measures = $measures
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('value', 'like', '%' . $search . '%')
                ->orWhereHas('unit', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }

        return $measures->where('client_id', $request->client_id)->orderBy($orderBy ?? 'created_At', 'desc')->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        try {
            $measure = Measure::create($request->all());
            return ResponseManager::success('Medida creada correctamente', [
                'measure' => $measure->load($this->relations)
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
            $measure = Measure::find($id);
            if (!$measure) {
                throw new \Exception("Medida no encontrada", 404);
            }
            return ResponseManager::success('Medida obtenida correctamente', [
                'measure' => $measure->load($this->relations)
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
            $measure = Measure::find($id);
            if(!$measure) throw new \Exception("No se encontro el medida", 404);

            $measure->update($request->all());

            return ResponseManager::success('Medida actualizada correctamente', [
                'measure' => $measure->load($this->relations)
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
            $measure = Measure::find($id);
            if (!$measure) {
                throw new \Exception("Medida no encontrada", 404);
            }
            $measure->delete();
            return ResponseManager::success('Medida eliminada correctamente');
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }
}
