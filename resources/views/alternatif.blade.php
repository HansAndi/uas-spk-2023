@extends('layouts.main')

@section('title', 'Alternatif')

@section('page-title', 'Alternatif')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Data Alternatif</h3>
                    <button type="button" class="btn btn-sm btn-success ml-auto" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        + Tambah Data
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Nama Alternatif</th>
                                @foreach ($kriteria as $krt)
                                    <th>C{{ $loop->iteration }}</th>
                                @endforeach
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alternatif as $item)
                                <tr>
                                    <td>{{ $item->nama_alternatif }}</td>
                                    @foreach ($kriteria as $krt)
                                        <td>
                                            @php
                                                $ak = $alternatifKriteriaGrouped[$item->id][$krt->id] ?? null;
                                            @endphp
                                            @if ($ak)
                                                {{ number_format($ak[0]->value, 4) }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        <button data-bs-toggle="modal" data-bs-target="#inputNilai"
                                            onclick='setAlternatif(@json($item))'
                                            class="btn btn-warning">Input
                                            Nilai</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteAltButton"
                                            onclick="deleteAlternatif({{ $item }})">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('alternatif') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_alternatif">Nama Alternatif</label>
                            <input type="text" class="form-control" id="nama_alternatif"
                                placeholder="Masukkan nama alternatif" name="nama_alternatif">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Modal Input -->
    <div class="modal fade" id="inputNilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <form action="{{ url('alternatif_kriteria') }}" method="POST">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <input name="nama_alternatif" class="modal-title form-control" id="namaAlternatif" value=""
                            readonly>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input name="alternatif_id" id="idAlternatif" type="hidden">

                        <div class="row">
                            <div class="col-md-6">
                                @foreach ($kriteria->take($kriteria->count() / 2) as $krt)
                                    <div class="form-group">
                                        <label for="nama_kriteria">{{ $krt->nama_kriteria }}</label>
                                        <select name="value[]" id="idKriteria" class="form-control">
                                            @foreach ($subKriteria as $sk)
                                                @if ($sk->kriteria_id == $krt->id)
                                                    <option value="{{ $sk->value }}">{{ $sk->range_kriteria }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <input name="id[]" id="idKriteria" type="hidden" value="{{ $krt->id }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @foreach ($kriteria->skip($kriteria->count() / 2) as $krt)
                                    <div class="form-group">
                                        <label for="nama_kriteria">{{ $krt->nama_kriteria }}</label>
                                        <select name="value[]" id="idKriteria" class="form-control">
                                            @foreach ($subKriteria as $sk)
                                                @if ($sk->kriteria_id == $krt->id)
                                                    <option value="{{ $sk->value }}">{{ $sk->range_kriteria }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <input name="id[]" id="idKriteria" type="hidden" value="{{ $krt->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- Modal for delete --}}
    <div class="modal fade" id="deleteAltButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleDeleteAlternatif">Hapus Alternatif</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="POST" id="deleteAlternatif">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function deleteAlternatif(data) {
            alternatif = data;
            console.log(alternatif);
            $('#deleteAlternatif').attr('action', '{{ url('alternatif') }}/' + alternatif.id);
        }

        // let alternatif;

        function setAlternatif(newAlternatif) {
            alternatif = newAlternatif;
            console.log(alternatif)
            document.getElementById('namaAlternatif').value = alternatif.nama_alternatif;
            document.getElementById('idAlternatif').value = alternatif.id;
        }
    </script>
@endsection
