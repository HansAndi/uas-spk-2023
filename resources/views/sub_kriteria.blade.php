@extends('layouts.main')

@section('title', 'Kriteria')

@section('page-title', 'Kriteria')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub Kriteria</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->


    <!-- Default box -->
    {{-- mengecek if kriteria isi nol --}}
    @if ($kriteria->count() == 0)
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <h1>Data Kosong</h1>
                </div>
            </div>
        </section>
    @endif

    @foreach ($kriteria as $item)
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">{{ $item->nama_kriteria }}
                    </h3>
                    <button type="button" class="btn btn-sm btn-success ml-auto" data-bs-toggle="modal"
                        data-bs-target="#kriteriaModal" onclick='setKriteria(@json($item))'>
                        + Tambah Data
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>Rentang Kriteria</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($sub_kriteria as $sub_item)
                                @if ($sub_item->kriteria_id == $item->id)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $sub_item->range_kriteria }}</td>
                                        <td>{{ number_format($sub_item->value, 4) }}</td>
                                        <td>
                                            <button data-bs-target="#updateSubKriteriaModal" data-bs-toggle="modal"
                                                class="btn btn-warning"
                                                onclick="setSubKriteria({{ $sub_item }})">Edit</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteSubButton"
                                                onclick="setSubKriteria({{ $sub_item }})">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endforeach

    <!-- Modal -->
    <div class="modal fade" id="kriteriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nama_kriteria"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('sub_kriteria') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Rentang Kriteria</label>
                            <input type="text" class="form-control" id="nama"
                                placeholder="Masukkan Rentang Kriteria" name="range_kriteria">
                        </div>
                        <div class="form-group">
                            <label for="bobot">Nilai</label>
                            <input type="number" step="0.01" class="form-control" id="bobot"
                                placeholder="Masukkan Nilai" name="value">
                        </div>
                        <input type="hidden" class="form-control" id="kriteria_id" name="kriteria_id" value="">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Update --}}
    <div class="modal fade" id="updateSubKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update_sub_kriteria"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateSubForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Rentang Kriteria</label>
                            <input type="text" class="form-control" id="updateRangeKriteria"
                                placeholder="Masukkan Rentang Kriteria" name="rangeKriteria">
                        </div>
                        <div class="form-group">
                            <label for="bobot">Nilai</label>
                            <input type="number" step="0.01" class="form-control" id="updateBobot"
                                placeholder="Masukkan Nilai" name="value">
                        </div>
                        <input type="hidden" class="form-control" id="updateIdSubKriteria" name="id"
                            value="">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for delete --}}
    <div class="modal fade" id="deleteSubButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleDeleteSubForm">Hapus Sub Kriteria</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="POST" id="deleteSubForm">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let kriteria;

    function setKriteria(newkriteria) {
        kriteria = newkriteria;
        console.log(kriteria);
        document.getElementById('nama_kriteria').innerHTML = kriteria.nama_kriteria;
        document.getElementById('kriteria_id').value = kriteria.id;
    }
</script>
<script>
    // kriteria hold the value of kriteria in json format
    const sub_kriteria = null;

    function setSubKriteria(sub_kriteria) {
        sub_kriteria = sub_kriteria;

        // ganti action form dari tag dengan deleteSubForm
        console.log(sub_kriteria)
        $('#deleteSubForm').attr('action', '{{ url('sub_kriteria') }}/' + sub_kriteria.id)
        $('#updateSubForm').attr('action', '{{ url('sub_kriteria') }}/' + sub_kriteria.id)
        document.getElementById('titleDeleteSubForm').innerHTML = sub_kriteria.range_kriteria

        $('#updateRangeKriteria').val(sub_kriteria.range_kriteria)
        $('#updateBobot').val(sub_kriteria.value)
        $('#updateIdSubKriteria').val(sub_kriteria.id)
    }
</script>
