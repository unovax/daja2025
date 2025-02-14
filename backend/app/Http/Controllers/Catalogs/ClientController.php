<?php

namespace App\Http\Controllers\Catalogs;

use App\Helpers\ResponseManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogs\Client\Store;
use App\Http\Requests\Catalogs\Client\Update;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->search);
        $perPage = $request->per_page;
        $orderBy = $request->order_by;

        $clients = Client::query();

        if ($search && $search != '') {
            $clients = $clients
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        }

        return $clients->orderBy($orderBy ?? 'created_At', 'desc')->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        try {
            $client = Client::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return ResponseManager::success('Cliente creado correctamente', [
                'client' => $client
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
            $client = Client::find($id);
            if (!$client) {
                throw new \Exception("Cliente no encontrado", 404);
            }
            return ResponseManager::success('Cliente obtenido correctamente', [
                'client' => $client
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
            $client = Client::find($id);
            if(!$client) throw new \Exception("No se encontro el cliente", 404);

            $client->update([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return ResponseManager::success('Cliente actualizado correctamente', [
                'client' => $client
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
            $client = Client::find($id);
            if (!$client) {
                throw new \Exception("Cliente no encontrada", 404);
            }
            $client->delete();
            return ResponseManager::success('Cliente eliminada correctamente');
        } catch (\Throwable $th) {
            return ResponseManager::error($th->getMessage());
        }
    }
}
