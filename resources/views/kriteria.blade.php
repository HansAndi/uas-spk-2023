@extends('layouts.main')

@section('title', 'Kriteria')

@section('page-title', 'Kriteria')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title"></i>Data Kriteria</h3>
                    <button type="button" class="btn btn-sm btn-success ml-auto" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        + Tambah Data
                    </button>
                </div>
                {{-- <div class="card-header">
                    <h4>Data Kriteria</h4>
                </div> --}}
                <div class="card-body">
                    <table class="table table-bordered table-hover custom-table text-center">
                        <thead>
                            <tr>
                                <th>Kode Kriteria</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $item)
                                <tr>
                                    <td>C{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_kriteria }}</td>
                                    <td>{{ $item->bobot }}</td>
                                    <td>{{ $item->tipe }}</td>
                                    <td>
                                        <button data-bs-toggle="modal" data-bs-target="#modalUpdate"
                                            onclick="updateKriteria({{ $item }})" class="btn btn-warning">Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteKrtButton" onclick="deleteKriteria({{ $item }})">
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
                    <form action="{{ url('kriteria') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukkan nama kriteria"
                                name="nama_kriteria">
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="number" step="0.01" class="form-control" id="bobot" placeholder="Bobot"
                                name="bobot">
                        </div>
                        <div class="form-group">
                            <label for="tipe">Atribut</label>
                            <select name="tipe" id="tipe">
                                <option value="Benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for update --}}
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Modal title</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('kriteria') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="updateKriteriaId" name="id">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="updateKriteriaName"
                                placeholder="Masukkan nama kriteria" name="nama_kriteria">
                        </div>
                        <div class="form-group">
                            <label for="bobot">Bobot</label>
                            <input type="number" step="0.01" class="form-control" id="updateKriteriaBobot"
                                placeholder="Bobot" name="bobot">
                        </div>
                        <div class="form-group">
                            <label for="tipe">Atribut</label>
                            <select name="tipe" id="updateKriteriaJenis">
                                <option value="Benefit">Benefit</option>
                                <option value="cost">Cost</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for delete --}}
    <div class="modal fade" id="deleteKrtButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleDeleteKriteria">Hapus Kriteria</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="" method="POST" id="deleteKriteria">
                        @csrf
                        @method('DELETE')
                        <button id="deleteBtn" class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function updateKriteria(data) {
            kriteria = data;
            $('#updateKriteriaId').val(kriteria.id);
            $('#updateKriteriaName').val(kriteria.nama_kriteria);
            $('#updateKriteriaBobot').val(kriteria.bobot);
            // $('#updateKriteriaJenis').val(kriteria.tipe);

            var option = document.getElementById('updateKriteriaJenis');
            if (kriteria.tipe == 'benefit') {
                option.selectedIndex = 0;
            } else if (kriteria.tipe == 'cost') {
                option.selectedIndex = 1;
            }
            // change the action url
            $('#modalUpdate form').attr('action', '{{ url('kriteria') }}/' + kriteria.id);
            console.log(kriteria);
        }

        function deleteKriteria(data) {
            kriteria = data;
            // console.log(kriteria.id);
            $('#deleteKriteria').attr('action', '{{ url('kriteria') }}/' + kriteria.id);
        }
    </script>
    <script>
        function setKriteria(newKriteria) {
            kriteria = newKriteria;
            // ganti action form dari tag dengan deleteKriteria
            console.log(kriteria)
            $('#deleteKriteria').attr('action', '{{ url('kriteria.') }}/' + kriteria.id)

        }
    </script>
@endsection
