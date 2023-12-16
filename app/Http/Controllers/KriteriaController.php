<?php

namespace App\Http\Controllers;

use App\Models\kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriteria = kriteria::all();
        $krt = kriteria::find(22);
        $totalBobot = kriteria::sum('bobot');
        // dd($totalBobot - $krt->bobot);
        return view('kriteria')->with('kriteria', $kriteria);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $totalBobot = kriteria::sum('bobot') + $request->bobot;

        if ($totalBobot > 1) {
            return redirect('kriteria')->with('alert', 'Total bobot tidak boleh lebih dari 1');
        } else {
            kriteria::create($request->all());
            return redirect('kriteria')->with('success', 'Kriteria berhasil ditambahkan');
        }
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
        $kriteria = kriteria::find($id);
        // $kriteria->update($request->all());
        // return redirect('kriteria')->with('success', 'Kriteria berhasil diupdate');
        $totalBobot = kriteria::sum('bobot') - $kriteria->bobot + $request->bobot;

        if ($totalBobot > 1) {
            return redirect('kriteria')->with('alert', 'Total bobot tidak boleh lebih dari 1');
        } else {
            $kriteria->update($request->all());
            return redirect('kriteria')->with('success', 'Kriteria berhasil diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        kriteria::find($id)->delete();

        return redirect('kriteria')->with('success', 'Kriteria berhasil dihapus');
    }
}
