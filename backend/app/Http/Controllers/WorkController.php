<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseManager;
use App\Http\Requests\Work\Store;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->search);
        $perPage = $request->per_page;
        $orderBy = $request->order_by;

        $works = Work::query();

       /*  if ($search && $search != '') {
            $works = $works
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        } */

        return $works->orderBy($orderBy ?? 'created_At', 'desc')->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $work = Work::create([
                'client_id' => $user->id,
                'notes' => $request->notes,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            $work->work_details()->create($request->work_details);
            DB::commit();
            return ResponseManager::success('Trabajo creado correctamente', [ 'work' => $work ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return ResponseManager::error($th->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
