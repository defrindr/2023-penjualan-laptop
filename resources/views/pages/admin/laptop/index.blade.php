@extends('layouts.admin.main')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <button class="btn btn-primary" id="btnOpenModalCreate">
                        <i class="fa fa-plus"></i> {{ __('Add Data') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Manufaktur</th>
                                    <th>Model</th>
                                    <th>Kategori</th>
                                    <th>Ukuran Layar</th>
                                    <th>Spesifikasi Layar</th>
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Penyimpanan</th>
                                    <th>GPU</th>
                                    <th>Sistem Operasi</th>
                                    <th>Versi S.O</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Manufaktur</th>
                                    <th>Model</th>
                                    <th>Kategori</th>
                                    <th>Ukuran Layar</th>
                                    <th>Spesifikasi Layar</th>
                                    <th>CPU</th>
                                    <th>RAM</th>
                                    <th>Penyimpanan</th>
                                    <th>GPU</th>
                                    <th>Sistem Operasi</th>
                                    <th>Versi S.O</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($items as $laptop)
                                    <tr>
                                        <td>{{ $laptop->manufacturer }}</td>
                                        <td>{{ $laptop->model_name }}</td>
                                        <td>{{ $laptop->category }}</td>
                                        <td>{{ $laptop->screen_size }}</td>
                                        <td>{{ $laptop->screen }}</td>
                                        <td>{{ $laptop->cpu }}</td>
                                        <td>{{ $laptop->ramLabel }}</td>
                                        <td>{{ $laptop->storage }}</td>
                                        <td>{{ $laptop->gpu }}</td>
                                        <td>{{ $laptop->operating_system }}</td>
                                        <td>{{ $laptop->operating_system_version }}</td>
                                        <td>{{ $laptop->weightLabel }}</td>
                                        <td>{{ $laptop->priceIdr }}</td>
                                        <td>
                                            <button class="btnEdit btn btn-warning mb-1 mr-1"
                                                data-id="{{ $laptop->id }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </button>
                                            <form action="/laptop/{{ $laptop->id }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" name="submit" class="btn btn-sm btn-danger mb-2"><i
                                                        class="fa fa-trash" aria-hidden="true"></i>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create --}}
    <div id="modalCreate" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <input type="hidden" id="create-field-id" name="id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formCreate">
                        <div class="form-group">
                            <label for="">Manufacturer</label>
                            <select name="manufacturer" id="create-field-manufacturer" class="form-control">
                                <option value=""> -- Pilih Manufaktur -- </option>
                                @foreach ($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer }}">{{ $manufacturer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Category</label>
                            <select name="category" id="create-field-category" class="form-control">
                                <option value=""> -- Pilih Manufaktur -- </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Model</label>
                                    <input type="text" class="form-control" id="create-field-model_name"
                                        name="model_name">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Ukuran Layar</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="create-field-screen_size"
                                            name="screen_size">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon3">Inch</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Spesifikasi Layar</label>
                            <textarea type="text" class="form-control" id="create-field-screen" name="screen"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">CPU</label>
                                    <input type="text" class="form-control" id="create-field-cpu" name="cpu">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">RAM</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="create-field-ram" name="ram">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon3">GB</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Penyimpanan</label>
                                    <input type="text" class="form-control" id="create-field-storage" name="storage">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">GPU</label>
                                    <input type="text" class="form-control" id="create-field-gpu" name="gpu">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Sistem Operasi</label>
                                    <input type="text" class="form-control" id="create-field-operating_system"
                                        name="operating_system">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Versi Sistem Operasi</label>
                                    <input type="text" class="form-control" id="create-field-operating_system_version"
                                        name="operating_system_version">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Berat</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="create-field-weight"
                                            name="weight">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon3">KG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">RP</span>
                                        </div>
                                        <input type="number" class="form-control" id="create-field-price"
                                            name="price">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="btn-save" type="button" class="btn btn-primary">{{ __('Save Changesß') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let table = new DataTable('#dataTable')

        let btnSave = $('#btn-save');
        let btnOpenModalCreate = $('#btnOpenModalCreate');

        let form = document.querySelector('#formCreate');

        const insertNewData = async (body) => {
            try {
                let response = await fetch("{{ route('admin.master.laptop.store') }}", {
                    method: 'POST',
                    body,
                    credentials: "same-origin",
                    headers: {
                        // "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                })
                let json = await response.json();

                alert(json.message)
                if (response.ok) {
                    window.location.href = "{{ route('admin.master.laptop.index') }}"
                }
            } catch (err) {
                alert(err?.responseJson?.message ?? 'Telah terjadi kesalahan saat memproses data')
            }
        }

        const updateData = async (id, body) => {
            body.append('_method', 'PUT');

            try {
                let response = await fetch("{{ route('admin.master.laptop.store') }}/" + id, {
                    method: 'POST',
                    body,
                    credentials: "same-origin",
                    headers: {
                        // "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                })
                let json = await response.json();

                alert(json.message)
                if (response.ok) {
                    window.location.href = "{{ route('admin.master.laptop.index') }}"
                }
            } catch (err) {
                alert(err?.responseJson?.message ?? 'Telah terjadi kesalahan saat memproses data')
            }
        }

        const getData = async (id) => {
            try {
                let response = await fetch("{{ route('admin.master.laptop.index') }}/" + id)
                let json = await response.json();

                let dataEntries = Object.entries(json.data)

                for (let i = 0; i < dataEntries.length; i++) {
                    let item = dataEntries[i];

                    if ($(`#create-field-${item[0]}`)) {
                        $(`#create-field-${item[0]}`).val(item[1])
                    }
                }

                $('#modalCreate').modal('show');
            } catch (err) {
                console.log(err)
                alert(err?.responseJson?.message ?? 'Telah terjadi kesalahan saat memproses data')
            }
        }

        btnOpenModalCreate.on('click', function() {
            $('#create-field-id').val('');
            $('#modalCreate').modal('show');
        });

        btnSave.on('click', function() {
            let payload = new FormData(form);
            let id = $('#create-field-id').val();

            if (id) {
                updateData(id, payload)
            } else {
                insertNewData(payload)
            }
        });

        $('.btnEdit').on('click', function(event) {
            let id = $(this).data('id');
            getData(id)
        });
    </script>
@endsection
