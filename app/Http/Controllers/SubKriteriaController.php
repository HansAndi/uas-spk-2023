<?php

namespace App\Http\Controllers;

use App\Models\sub_kriteria;
use Illuminate\Http\Request;
use App\Models\kriteria;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_kriteria = sub_kriteria::orderBy('value', 'asc')->get();
        $kriteria = kriteria::all();
        return view('sub_kriteria')->with('sub_kriteria', $sub_kriteria)->with('kriteria', $kriteria);
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
        sub_kriteria::create($request->all());
        return redirect('sub_kriteria')->with('success', 'Sub Kriteria berhasil ditambahkan');
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
        $sub_kriteria = sub_kriteria::find($id);
        $sub_kriteria->update($request->all());

        return redirect('sub_kriteria')->with('success', 'Sub Kriteria berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sub_kriteria = sub_kriteria::find($id);
        $sub_kriteria->delete();

        return redirect('sub_kriteria')->with('success', 'Sub Kriteria berhasil dihapus');
    }
}
