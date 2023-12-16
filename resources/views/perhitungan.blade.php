@extends('layouts.main')

@section('title', 'Perhitungan')

@section('page-title', 'Perhitungan')

@section('content')
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Bobot Kriteria</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                @foreach ($kriteria as $item)
                                    <th>{{ $item->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $item)
                                <td>{{ $item->bobot }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Matriks Keputusan</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <th>Nama Alternatif</th>
                            @foreach ($kriteria as $krt)
                                <th>{{ $krt->nama_kriteria }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($alternatif); $i++)
                                <tr>
                                    <td>{{ $alternatif[$i]->nama_alternatif }}</td>
                                    @for ($j = 0; $j < count($kriteria); $j++)
                                        <td>{{ $matriksKeputusan[$i][$j] }}</td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Matriks Normalisasi</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <th>Nama Alternatif</th>
                            @foreach ($kriteria as $krt)
                                <th>{{ $krt->nama_kriteria }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($alternatif); $i++)
                                <tr>
                                    <td>{{ $alternatif[$i]->nama_alternatif }}</td>
                                    @for ($j = 0; $j < count($kriteria); $j++)
                                        <td>{{ number_format($matriksNormalisasi[$i][$j], 4) }}</td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Matriks Preferensi</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <th>Nama Alternatif</th>
                            <th>Hasil</th>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($alternatif); $i++)
                                <tr>
                                    <td>{{ $alternatif[$i]->nama_alternatif }}</td>
                                    <td>{{ number_format($matriksPreferensi[$i], 4) }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Ranking</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <th>Ranking</th>
                            <th>Nama Alternatif</th>
                            <th>Hasil</th>
                        </thead>
                        <tbody>
                            {{-- @for ($i = 0; $i < count($ranking); $i++)
                                @php
                                    $alternative = $alternatif->where('id', $i)->first();
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $alternative->nama_alternatif }}</td>
                                    <td>{{ number_format($ranking[$i], 4) }}</td>
                                </tr>
                            @endfor --}}
                            @foreach ($ranking as $key => $value)
                                @php
                                    $alternative = $alternatif->where('id', $key)->first();
                                    // dd($alternative->nama_alternatif);
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alternatif[$key]->nama_alternatif }}</td>
                                    <td>{{ number_format($ranking[$key], 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
