<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use App\Models\alternatif_kriteria;
use App\Models\kriteria;
use App\Models\sub_kriteria;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function index()
    {

        $alternatif = alternatif::all();
        $kriteria = kriteria::all();
        $alternatif_kriteria = alternatif_kriteria::all();
        $alternatifKriteriaGrouped = $alternatif_kriteria->groupBy(['alternatif_id', 'kriteria_id']);

        $matriksKeputusan = $this->matriksKeputusan($alternatif, $kriteria, $alternatif_kriteria);
        $matriksNormalisasi = $this->matriksNormalisasi($matriksKeputusan, $kriteria);
        $matriksPreferensi = $this->matriksPreferensi($matriksNormalisasi, $kriteria);
        $ranking = $this->ranking($matriksPreferensi);

        // $matriksNormalisasi[0][8] = round(1 / 6, 4);
        // dd($matriksNormalisasi[0][8]);

        // foreach ($ranking as $key => $value) {
        //     $alternative = $alternatif->where('id', $key)->first();
        //     // dd($key, $value, $alternative);
        //     dd(number_format($ranking[$key], 4));
        // }

        // dd($ranking);
        // dd($matriksPreferensi);

        // return view('perhitungan')
        //     ->with('alternatif', $alternatif)
        //     ->with('kriteria', $kriteria)
        //     ->with('alternatif_kriteria', $alternatif_kriteria)
        //     // ->with('alternatifKriteriaGrouped', $alternatifKriteriaGrouped)
        //     ->with('matriksKeputusan', $matriksKeputusan)
        //     ->with('matriksNormalisasi', $matriksNormalisasi)
        //     ->with('matriksPreferensi', $matriksPreferensi)
        //     ->with('ranking', $ranking);

        return view('perhitungan', [
            'alternatif' => $alternatif,
            'kriteria' => $kriteria,
            'alternatif_kriteria' => $alternatif_kriteria,
            'matriksKeputusan' => $matriksKeputusan,
            'matriksNormalisasi' => $matriksNormalisasi,
            'matriksPreferensi' => $matriksPreferensi,
            'ranking' => $ranking,
        ]);
    }

    // public function matriksKeputusan($alternatif, $kriteria, $alternatif_kriteria)
    // {
    //     $matriksKeputusan = [];
    //     foreach ($alternatif as $key => $value) {
    //         foreach ($kriteria as $key2 => $value2) {
    //             $matriksKeputusan[$key][$key2] = $alternatif_kriteria[$value->id][$value2->id][0]->value;
    //         }
    //     }
    //     return $matriksKeputusan;
    // }

    public function matriksKeputusan($alternatif, $kriteria, $alternatif_kriteria)
    {
        $matriksKeputusan = [];
        foreach ($alternatif as $key => $value) {
            foreach ($kriteria as $key2 => $value2) {
                $matriksKeputusan[$key][$key2] = $alternatif_kriteria->where('alternatif_id', $value->id)->where('kriteria_id', $value2->id)->first()->value;
            }
        }
        return $matriksKeputusan;
    }

    //create matriks normalisasi where if kriteria->type == 'benefit' then value / max value else min value / value
    public function matriksNormalisasi($matriksKeputusan, $kriteria)
    {
        $matriksNormalisasi = [];
        foreach ($matriksKeputusan as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($kriteria[$key2]->tipe == 'benefit') {
                    // dd($this->maxValue($matriksKeputusan, $key2));
                    $matriksNormalisasi[$key][$key2] = $value2 / $this->maxValue($matriksKeputusan, $key2);
                } else if ($kriteria[$key2]->tipe == 'cost') {
                    $matriksNormalisasi[$key][$key2] = $this->minValue($matriksKeputusan, $key2) / $value2;
                }
            }
        }
        return $matriksNormalisasi;
    }

    public function maxValue($matriksKeputusan, $key)
    {
        $maxValue = $matriksKeputusan[0][$key];
        foreach ($matriksKeputusan as $key2 => $value2) {
            if ($value2[$key] > $maxValue) {
                $maxValue = $value2[$key];
            }
        }
        return $maxValue;
    }

    public function minValue($matriksKeputusan, $key)
    {
        $minValue = $matriksKeputusan[0][$key];
        foreach ($matriksKeputusan as $key2 => $value2) {
            if ($value2[$key] < $minValue) {
                $minValue = $value2[$key];
            }
        }
        return $minValue;
    }

    //create matriks preferensi where sum of kriteria->bobot * matriksNormalisasi
    public function matriksPreferensi($matriksNormalisasi, $kriteria)
    {
        $matriksPreferensi = [];
        foreach ($matriksNormalisasi as $key => $value) {
            $matriksPreferensi[$key] = 0;
            foreach ($value as $key2 => $value2) {
                $matriksPreferensi[$key] += $kriteria[$key2]->bobot * $value2;
            }
        }
        return $matriksPreferensi;
    }

    //create ranking where sort matriksPreferensi descending
    public function ranking($matriksPreferensi)
    {
        $ranking = [];
        foreach ($matriksPreferensi as $key => $value) {
            $ranking[$key] = $value;
        }
        arsort($ranking);
        return $ranking;
    }

    //create ranking where sort matriksPreferensi descending using usort
    // public function ranking($matriksPreferensi)
    // {
    //     $ranking = $matriksPreferensi;
    //     usort($ranking, function ($a, $b) {
    //         return $b <=> $a;
    //     });
    //     return $ranking;
    // }
}
