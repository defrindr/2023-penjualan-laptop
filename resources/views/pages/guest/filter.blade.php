<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="card card-default mb-4">
                    <div class="card-header">
                        <h3>Decision Tree, Rekomendasi Pembelian Laptop</h3>
                    </div>
                    <div class="card-body">

                        <div>
                            <button id="btnSearch" class="btn btn-success d-block w-100">
                                <i class="fa fa-check"></i> Cari
                            </button>
                        </div>
                        <form id="form-search" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Kategori</h3>
                                    @foreach ($categories as $item)
                                        <div class="form-group">
                                            <input type="checkbox" name="categories[]" value="{{ $item }}">
                                            <label for="">{{ $item }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <h3>Manufaktur</h3>
                                    @foreach ($manufacturers as $item)
                                        <div class="form-group">
                                            <input type="checkbox" name="manufactur[]" value="{{ $item }}">
                                            <label for="">{{ $item }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Harga Minumum</label>
                                <input type="number" name="minimum_price" value="" class="form-control">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Harga maksimum</label>
                                <input type="number" name="maximum_price" value="" class="form-control">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">RAM</label>
                                <input type="number" name="ram" value="" class="form-control">
                            </div>
                            <div class="row">

                                <div class="col-md-12 mb-2">
                                    <h3>Ukuran Layar</h3>
                                    @foreach ($screenSizes as $size)
                                        <div class="form-group">
                                            <input type="checkbox" name="screen_size[]" value="{{ $size }}">
                                            <label for="">{{ $size }} Inch</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-12 mb-2">
                                    <h3>CPU</h3>
                                    @foreach ($cpus as $cpu)
                                        <div class="form-group">
                                            <input type="checkbox" name="cpu[]" value="{{ $cpu }}">
                                            <label for="">{{ $cpu }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-12 mb-2">
                                    <h3>Penyimpanan</h3>
                                    @foreach ($storages as $storage)
                                        <div class="form-group">
                                            <input type="checkbox" name="storage[]" value="{{ $storage }}">
                                            <label for="">{{ $storage }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <div class="card card-default mb-4">
                    <div class="card-header">
                        <h3>Hasil Klasifikasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 500px;">
                            <table class="table table-hover table-striped">
                                <thead>
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
                                </thead>
                                <tbody id="table-result">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    let btnSearch = document.querySelector('#btnSearch');
    let tableResult = document.querySelector('#table-result');


    const analystAnswer = async (form) => {
        try {
            tableResult.innerHTML = `<tr><td colspan='14' class='text-center'>Loading ...</td></tr>`
            let response = await fetch("{{ route('filter.analyst') }}/", {
                method: 'POST',
                body: form,
                credentials: "same-origin",
                headers: {
                    // "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content')
                },
            })
            let json = await response.json();

            tableResult.innerHTML = '';
            json.items?.map(item => {
                tableResult.innerHTML += `<tr>
                                            <td>${item.manufacturer}</td>
                                            <td>${item.model_name}</td>
                                            <td>${item.category}</td>
                                            <td>${item.screen_size}</td>
                                            <td>${item.screen}</td>
                                            <td>${item.cpu}</td>
                                            <td>${item.ramLabel}</td>
                                            <td>${item.storage}</td>
                                            <td>${item.gpu}</td>
                                            <td>${item.operating_system}</td>
                                            <td>${item.operating_system_version}</td>
                                            <td>${item.weightLabel}</td>
                                            <td>${item.priceIdr}</td>
                                          </tr>`;
            })
        } catch (err) {
            console.log(err)
            tableResult.innerHTML =
                `<tr><td colspan='14' class='text-center'>Telah terjadi kesalahan saat memproses data</td></tr>`
            alert(err?.responseJson?.message ?? 'Telah terjadi kesalahan saat memproses data')
        }
    }


    btnSearch.addEventListener('click', function() {
        let form = new FormData(document.querySelector('#form-search'))

        analystAnswer(form);
    })
</script>

</html>
