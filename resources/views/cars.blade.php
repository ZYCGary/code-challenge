<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cars</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body class="antialiased">
<h1>Cars</h1>

{{--Car list--}}
<div>
    <ul id="carList"></ul>
</div>
</body>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* List cars */
        listCars();

        function listCars() {
            // Get car list
            $.ajax({
                type: 'GET',
                url: '{{ route('api.cars.index') }}',
                dataType: 'json'
            }).done(function (data) {
                // Remove duplicate cars
                data = removeDuplicates(data)

                // Order list
                let carsList = generateAlphabetObject();

                for (const [id, car] of Object.entries(data)) {
                    const initial = car[0].toUpperCase()
                    carsList[initial].push(`${car} (${id})`)
                }

                // Draw list
                showCarList(carsList)
            }).fail(function (data) {
                alert(data.responseText);
            })
        }

        function showCarList(list) {
            let carList = $('#carList');

            for (const [initial, cars] of Object.entries(list)) {
                let alphabetLi = $('<li>').html(initial)
                let sublist = $('<ul>')
                alphabetLi.append(sublist)

                if (cars.length === 0) {
                    sublist.append($('<li>').html('No vehicle could be found'))
                } else {
                    for (const car of cars) {
                        sublist.append($('<li>').html(car))
                    }
                }

                carList.append(alphabetLi)
            }
        }

        function generateAlphabetObject() {
            let alphabets = {};
            let start = 'A'.charCodeAt(0);
            let last = 'Z'.charCodeAt(0);

            for (let i = start; i <= last; ++i) {
                alphabets[String.fromCharCode(i)] = [];
            }

            return alphabets;
        }

        function removeDuplicates(list){
            let newList = {}

            for (const [id, car] of Object.entries(list)) {
                if (Object.values(newList).indexOf(car) === -1) {
                    newList[id] = car
                }
            }

            return newList
        }
    })
</script>
</html>
