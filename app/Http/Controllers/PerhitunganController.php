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
        // dd($kriteria);
        $alternatif_kriteria = alternatif_kriteria::all();
        $alternatifKriteriaGrouped = $alternatif_kriteria->groupBy(['alternatif_id', 'kriteria_id']);

        $matriksKeputusan = $this->matriksKeputusan($alternatif, $kriteria, $alternatif_kriteria);
        $matriksNormalisasi = $this->matriksNormalisasi($matriksKeputusan, $kriteria);
        // dd($matriksNormalisasi);
        // $matriksPreferensi = $this->matriksPreferensi($matriksNormalisasi, $kriteria);
        $matriksNormalisasiTerbobot = $this->matriksNormalisasiTerbobot($matriksNormalisasi, $kriteria);
        // dd($matriksNormalisasiTerbobot);

        $solusi_ideal_positif = $this->hitungSolusiIdealPositif($matriksNormalisasiTerbobot, $alternatif, $kriteria);
        // dd($solusi_ideal_positif);
        $solusi_ideal_negatif = $this->hitungSolusiIdealNegatif($matriksNormalisasiTerbobot);

        $jarak_solusi_ideal_positif = $this->hitungJarakSolusiIdealPositif($matriksNormalisasiTerbobot, $solusi_ideal_positif);
        // dd($jarak_solusi_ideal_positif);
        $jarak_solusi_ideal_negatif = $this->hitungJarakSolusiIdealNegatif($matriksNormalisasiTerbobot, $solusi_ideal_negatif);
        // dd($jarak_solusi_ideal_negatif);

        $matriksPreferensi = $this->hitungNilaiPreferensi($jarak_solusi_ideal_positif, $jarak_solusi_ideal_negatif);
        // dd($matriksPreferensi);
        $ranking = $this->ranking($matriksPreferensi);
        // dd($ranking);

        return view('perhitungan', [
            'alternatif' => $alternatif,
            'kriteria' => $kriteria,
            'alternatif_kriteria' => $alternatif_kriteria,
            'matriksKeputusan' => $matriksKeputusan,
            'matriksNormalisasi' => $matriksNormalisasi,
            'matriksNormalisasiTerbobot' => $matriksNormalisasiTerbobot,
            'solusi_ideal_positif' => $solusi_ideal_positif,
            'solusi_ideal_negatif' => $solusi_ideal_negatif,
            'jarak_solusi_ideal_positif' => $jarak_solusi_ideal_positif,
            'jarak_solusi_ideal_negatif' => $jarak_solusi_ideal_negatif,
            'matriksPreferensi' => $matriksPreferensi,
            'ranking' => $ranking,
        ]);
    }

    private function matriksKeputusan($alternatif, $kriteria, $alternatif_kriteria)
    {
        $matriksKeputusan = [];
        foreach ($alternatif as $key => $value) {
            foreach ($kriteria as $key2 => $value2) {
                $matriksKeputusan[$key][$key2] = $alternatif_kriteria->where('alternatif_id', $value->id)->where('kriteria_id', $value2->id)->first()->value;
            }
        }
        return $matriksKeputusan;
    }

    private function matriksNormalisasi($matriksKeputusan)
    {
        $matriksNormalisasi = [];
        for ($j = 0; $j < count($matriksKeputusan[0]); $j++) {
            $jumlah_kuadrat = 0;
            for ($i = 0; $i < count($matriksKeputusan); $i++) {
                $jumlah_kuadrat += pow($matriksKeputusan[$i][$j], 2);
            }
            for ($i = 0; $i < count($matriksKeputusan); $i++) {
                $matriksNormalisasi[$i][$j] = number_format($matriksKeputusan[$i][$j] / sqrt($jumlah_kuadrat), 4);
            }
        }
        return $matriksNormalisasi;
    }

    private function matriksNormalisasiTerbobot($matriksNormalisasi, $kriteria)
    {
        $matriksNormalisasiTerbobot = [];
        for ($i = 0; $i < count($matriksNormalisasi); $i++) {
            $matriksNormalisasiTerbobot[$i] = [];
            for ($j = 0; $j < count($matriksNormalisasi[0]); $j++) {
                $matriksNormalisasiTerbobot[$i][$j] = number_format($matriksNormalisasi[$i][$j] * $kriteria[$j]->bobot, 4);
            }
        }
        return $matriksNormalisasiTerbobot;
    }

    private function hitungSolusiIdealPositif($matriksNormalisasiTerbobot, $alternatif, $kriteria)
    {
        $type = kriteria::pluck('tipe')->toArray();
        // dd($type);
        $solusi_ideal_positif = [];
        for ($j = 0; $j < count($matriksNormalisasiTerbobot[0]); $j++) {
            $column = array_column($matriksNormalisasiTerbobot, $j);
            $max = max($column);
            $min = min($column);
            if (isset($type[$j])) {
                if ($type[$j] == 'Benefit' || $type[$j] == 'benefit') {
                    $solusi_ideal_positif[$j] = $max;
                } else if ($type[$j] == 'Cost' || $type[$j] == 'cost') {
                    $solusi_ideal_positif[$j] = $min;
                }
            }
        }
        return $solusi_ideal_positif;
    }

    private function hitungSolusiIdealNegatif($matriksNormalisasiTerbobot)
    {
        $type = kriteria::pluck('tipe')->toArray();
        // dd($type);
        $solusi_ideal_negatif = [];
        for ($j = 0; $j < count($matriksNormalisasiTerbobot[0]); $j++) {
            $column = array_column($matriksNormalisasiTerbobot, $j);
            $max = max($column);
            $min = min($column);
            if (isset($type[$j])) {
                if ($type[$j] == 'Benefit' || $type[$j] == 'benefit') {
                    $solusi_ideal_negatif[$j] = $min;
                } else if ($type[$j] == 'Cost' || $type[$j] == 'cost') {
                    $solusi_ideal_negatif[$j] = $max;
                }
            }
        }
        return $solusi_ideal_negatif;
    }

    private function hitungJarakSolusiIdealPositif($matriksNormalisasiTerbobot, $solusi_ideal_positif)
    {
        $jarak_solusi_ideal_positif = [];
        for ($i = 0; $i < count($matriksNormalisasiTerbobot); $i++) {
            $jarak = 0;

            for ($j = 0; $j < count($matriksNormalisasiTerbobot[0]); $j++) {
                if (isset($solusi_ideal_positif[$j])) {
                    $jarak += pow(($solusi_ideal_positif[$j] - $matriksNormalisasiTerbobot[$i][$j]), 2);
                }
            }
            $jarak_solusi_ideal_positif[$i] = number_format(sqrt($jarak), 4);
        }
        return $jarak_solusi_ideal_positif;
    }

    private function hitungJarakSolusiIdealNegatif($matriksNormalisasiTerbobot, $solusi_ideal_negatif)
    {
        $jarak_solusi_ideal_negatif = [];
        for ($i = 0; $i < count($matriksNormalisasiTerbobot); $i++) {
            $jarak = 0;

            for ($j = 0; $j < count($matriksNormalisasiTerbobot[0]); $j++) {
                if (isset($solusi_ideal_negatif[$j])) {
                    $jarak += pow(($matriksNormalisasiTerbobot[$i][$j] - $solusi_ideal_negatif[$j]), 2);
                }
            }
            $jarak_solusi_ideal_negatif[$i] = number_format(sqrt($jarak), 4);
        }
        return $jarak_solusi_ideal_negatif;
    }

    private function hitungNilaiPreferensi($jarak_solusi_ideal_positif, $jarak_solusi_ideal_negatif)
    {
        $nilai_preferensi = [];
        for ($i = 0; $i < count($jarak_solusi_ideal_positif); $i++) {
            $nilai_preferensi[$i] = number_format($jarak_solusi_ideal_negatif[$i] / ($jarak_solusi_ideal_positif[$i] + $jarak_solusi_ideal_negatif[$i]), 4);
        }
        return $nilai_preferensi;
    }
    public function ranking($matriksPreferensi)
    {
        $ranking = [];
        foreach ($matriksPreferensi as $key => $value) {
            $ranking[$key] = $value;
        }
        arsort($ranking);
        return $ranking;
    }
}
