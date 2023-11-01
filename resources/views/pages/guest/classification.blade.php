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
    <div class="container mt-3">
        <div class="card card-default mb-4">
            <div class="card-header">
                <h3>Decision Tree, Rekomendasi Pembelian Laptop</h3>
            </div>
            <div class="card-body">
                <div id="form-container">
                </div>
                <div>
                    <button id="btnAnalyst" class="btn btn-success" disabled>
                        <i class="fa fa-check"></i> Analisa
                    </button>
                    <button id="btnUlangi" class="btn btn-danger" disabled>
                        <i class="fa fa-check"></i> Ulangi
                    </button>
                </div>
            </div>
        </div>
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
</body>

<script>
    let btnAnalyst = document.querySelector('#btnAnalyst');

    let tableResult = document.querySelector('#table-result');

    let questions = {!! json_encode($questions, JSON_PRETTY_PRINT) !!};
    let selectedQuestion = questions[0];
    let answers = [];
    let position = 0;

    /**
     *
     * 0 = question
     * 1 = true condition
     * 2 = false condition
     * 3 = can end
     * 4 = end_in 
     * 
     * */

    const setAnswer = (parent, index, value) => {
        answers.push(value);
        HideAllElement()


        if (answers.length) {
            document.querySelector('#btnUlangi').removeAttribute('disabled')
        }

        if (selectedQuestion && selectedQuestion.children && selectedQuestion.children[value]) {
            selectedQuestion = selectedQuestion.children[value];
        } else {
            btnAnalyst.removeAttribute('disabled', 0)
            return;
        }

        let nextQuestion = document.querySelector(`#question-${parent+1}-${value}`);
        console.log(`#question-${parent+1}-${value}`)
        if (nextQuestion) {
            nextQuestion.classList.remove('d-none')
            nextQuestion.classList.add('d-block')
        } else {
            btnAnalyst.removeAttribute('disabled', 0)
        }
    }

    const HideAllElement = () => {
        let elements = document.querySelectorAll(`[id^='question']`);
        for (let i = 0; i < elements.length; i++) {
            elements[i].classList.remove('d-block');
            elements[i].classList.add('d-none');
        }
    }

    const initialRunning = (listQuestions, parent = 0) => {
        if (parent === 0) {
            tableResult.innerHTML =
                `<tr><td colspan='14' class='text-center'>hasil akan ditampilkan disini</td></tr>`
        }
        if (!listQuestions) return;
        listQuestions.map((item, index) => {
            if (!item) return;
            document.querySelector('#form-container').innerHTML += `
              <div id='question-${parent}-${index}' class="form-group mb-3 ${parent === 0 && index == 0 ? '' : 'd-none'}">
                  <label for="">${item.question}</label>
                  <br/>
                  <br/>
                  <button onclick="setAnswer(${parent}, ${index}, 0)" class="btn btn-primary d-inline-block">YA</button>
                  <button onclick="setAnswer(${parent}, ${index}, 1)" class="btn btn-danger d-inline-block">TIDAK</button>
              </div>
            `;
            initialRunning(item.children, parent + 1)
        });
    }


    const analystAnswer = async () => {
        try {
            tableResult.innerHTML = `<tr><td colspan='14' class='text-center'>Loading ...</td></tr>`
            let response = await fetch("{{ route('classification.analyst') }}/", {
                method: 'POST',
                body: JSON.stringify({
                    'answers': answers
                }),
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
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


    btnAnalyst.addEventListener('click', function(event) {
        event.preventDefault();

        analystAnswer();
    })

    document.querySelector('#btnUlangi').addEventListener('click', function() {
        answers = [];
        selectedQuestion = questions[0];
        document.querySelector('#form-container').innerHTML = '';
        initialRunning(questions);
        document.querySelector('#btnUlangi').setAttribute('disabled', 1)
    })

    initialRunning(questions);
</script>

</html>
