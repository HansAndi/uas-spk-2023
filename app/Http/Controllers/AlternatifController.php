<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use App\Models\alternatif_kriteria;
use App\Models\kriteria;
use App\Models\sub_kriteria;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatif = alternatif::all();
        $kriteria = kriteria::all();
        $alternatif_kriteria = alternatif_kriteria::all();
        $alternatifKriteriaGrouped = $alternatif_kriteria->groupBy(['alternatif_id', 'kriteria_id']);
        // dd($altKrt);
        $subKriteria = sub_kriteria::all();
        return view('alternatif')
            ->with('alternatif', $alternatif)
            ->with('kriteria', $kriteria)
            ->with('alternatif_kriteria', $alternatif_kriteria)
            ->with('alternatifKriteriaGrouped', $alternatifKriteriaGrouped)
            ->with('subKriteria', $subKriteria);
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
        alternatif::create($request->all());
        return redirect('alternatif')->with('success', 'Alternatif berhasil ditambahkan');
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
        $alternatif = alternatif::find($id);
        $alternatif->update($request->all());

        return redirect('alternatif')->with('success', 'Alternatif berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alternatif = alternatif::find($id);
        $alternatif->delete();

        return redirect('alternatif')->with('success', 'Alternatif berhasil dihapus');
    }
}
