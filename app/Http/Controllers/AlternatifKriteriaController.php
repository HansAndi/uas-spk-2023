<?php

namespace App\Http\Controllers;

use App\Models\alternatif_kriteria;
use App\Models\alternatif;
use Illuminate\Http\Request;

class AlternatifKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $alternatif_id = $request->alternatif_id;

        $alternatif = alternatif::find($alternatif_id);
        $alternatif->update([
            'nama_alternatif' => $request->nama_alternatif,
        ]);

        foreach ($request->id as $key => $value) {
            // check if data with 'alternatif_id' and 'id_kriteria' already exists on table 'alternatif_kriteria'
            $alternatif_kriteria = alternatif_kriteria::where('alternatif_id', $alternatif_id)
                ->where('kriteria_id', $request->id[$key])
                ->first();

            // if data already exists, update the data
            if ($alternatif_kriteria) {
                $alternatif_kriteria->update([
                    'value' => $request->value[$key],
                ]);
                continue;
            } else {
                // if data doesn't exist, create new data
                alternatif_kriteria::create([
                    'alternatif_id' => $alternatif_id,
                    'kriteria_id' => $request->id[$key],
                    'value' => $request->value[$key],
                ]);
            }
        }
        return redirect('alternatif')
            ->with('success', 'Alternatif berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
