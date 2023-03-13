@extends('layouts.app')

@section('title', 'Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex flex-wrap">
                    <div>
                        <h4 class="card-title">Data Admin</h4>
                        <p class="card-title-desc">
                            Data Admin Thrift
                        </p>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                            <i class="bx bx-plus align-middle me-1"></i> New
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>PHOTO</th>
                            <th>EMAIL</th>
                            <th>NAME</th>
                            <th>ADDRESS</th>
                            <th>PHONE</th>
                            <th>ACT</th>
                        </tr>
                        </thead>
                        <tbody class="text-nowrap">
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ url('admin/' . $item->photo) }}" height="100" width="100"></td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="edit({{ $item->id }})">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus({{ $item->id }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<!-- modal tambah -->
<div id="modal-tambah" class="modal fade" tabindex="-1" aria-labelledby="modal-tambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="form-tambah">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Photo</label>
                                <input class="form-control" type="file" name="photo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Phone</label>
                                <input class="form-control" type="text" name="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Latitude</label>
                                <input class="form-control" type="text" name="latitude" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Longitude</label>
                                <input class="form-control" type="text" name="longitude" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- modal edit -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="modal-edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" id="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Photo</label>
                                <input class="form-control" type="file" name="photo">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Phone</label>
                                <input class="form-control" type="text" name="phone" id="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Latitude</label>
                                <input class="form-control" type="text" name="latitude" id="latitude" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Longitude</label>
                                <input class="form-control" type="text" name="longitude" id="longitude" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('javascript')
<script>
$(document).ready( function () {
    $('#datatable').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching": true,
        "lengthChange": true,
        "pageLength": 10,
    });
});

$("#form-tambah").submit(function(event) {
    event.preventDefault();
    Swal.fire({
        title: "Simpan data?",
        text: "Data akan disimpan ke database",
        icon: "warning",showCancelButton:!0,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            var form_data = new FormData(this);
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }});
            $.ajax({
                url: "{{ route('admin.store') }}",
                processData: false,
                contentType: false,
                cache: false,
                type: "post",
                enctype: 'multipart/form-data',
                data: form_data,
                success: function(response) {
                    Swal.fire(response.title, response.message, response.icon);
                    location.reload();
                }
            })
        }
    })
});

function edit(id) {
    $.ajax({
        type:"get",
        url: "{{ route('admin.edit') }}",
        dataType: 'json',
        data: {
            id: id,
        },
        success: function(response) {
            $('#form-edit').trigger('reset');
            $('#id').val(response.id);
            $('#email').val(response.email);
            $('#name').val(response.name);
            $('#description').val(response.description);
            $('#address').val(response.address);
            $('#phone').val(response.phone);
            $('#latitude').val(response.latitude);
            $('#longitude').val(response.longitude);
            $('#modal-edit').modal('show');
        }
    });
}

$("#form-edit").submit(function(event) {
    event.preventDefault();
    Swal.fire({
        title: "Perbarui data?",
        text: "Data akan diperbarui",
        icon: "warning",showCancelButton:!0,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Ya, Perbarui!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            var form_data = new FormData(this);
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }});
            $.ajax({
                url: "{{ route('admin.update') }}",
                processData: false,
                contentType: false,
                cache: false,
                type: "post",
                enctype: 'multipart/form-data',
                data: form_data,
                success: function(response) {
                    Swal.fire(response.title, response.message, response.icon);
                    location.reload();
                }
            })
        }
    })
});

function hapus(id) {
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Kamu tidak akan dapat mengembalikan ini!",
        icon: "warning",showCancelButton:!0,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }});
            $.ajax({
                type:"delete",
                url: "{{ route('admin.delete') }}",
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function(response) {
                    Swal.fire(response.title, response.message, response.icon);
                    location.reload();
                }
            });
        }
    })
}
</script>
@endsection