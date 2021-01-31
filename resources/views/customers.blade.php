<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Customers</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
</head>
<body class="antialiased">
<h1>Customers</h1>
<a href="{{ route('page.car') }}">Car Makes</a>

{{--New customer--}}
<div>
    <h2>New Customer</h2>

    <form id="addCustomerForm">
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="mobile">Mobile</label>
            <input type="text" id="mobile" name="mobile">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email">
        </div>
        <div>
            <label for="country">Country</label>
            <select id="country" name="country">
                <option disabled>Select your country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="active">Active</label>
            <select id="active" name="active">
                <option value="1">Y</option>
                <option value="0">N</option>
            </select>
        </div>

        <button type="submit">ADD</button>
        <span id="addResult"></span>
    </form>
</div>

{{--Custoer list--}}
<div>
    <h2>Customer List</h2>

    <div id="filter">
        <button name="all">All</button>
        <button name="active">Active</button>
        <button name="not-active">Not Active</button>
    </div>

    <table id="customerList">
        <thead>
        <tr>
            <th>CustomerID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Country</th>
        </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
</div>
</body>

<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* New customer form submission */
        let addCustomerForm = $('#addCustomerForm')

        // Validate form input
        addCustomerForm.validate({
            rules: {
                'name': {
                    required: true,
                    minlength: 4,
                    maxlength: 20,
                },
                'mobile': {
                    required: true,
                    number: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'country': {
                    required: true
                },
                'active': {
                    required: true
                },
            }
        })

        // Submit form
        addCustomerForm.submit((event) => {
            event.preventDefault();

            if (addCustomerForm.valid()) {
                let data = {
                    name: $('#name').val(),
                    mobile: $('#mobile').val(),
                    email: $('#email').val(),
                    country: $('#country').val(),
                    active: $('#active').val()
                };

                let url = '{{ route('api.customers.store') }}'

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'json',
                }).done(function (data) {
                    listCustomers('active');
                    alert('The new customer is added!')
                }).fail(function (data) {
                    alert(data.responseText);
                })
            }
        })

        /* List customers */
        listCustomers('active');

        function listCustomers(filter) {
            let customerList = $('#customerList>tbody');

            // Clear table
            customerList.empty();

            // Get customer list
            let url = filter
                ? '{{ route('api.customers.index') }}' + `?limit=${filter}`
                : '{{ route('api.customers.index') }}'

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json'
            }).done(function (data) {
                for (let customer of data) {
                    let id = $('<td>').html(customer.id);
                    let name = $('<td>').html(customer.name);
                    let mobile = $('<td>').html(customer.mobile);
                    let email = $('<td>').html(customer.email);
                    let country = $('<td>').html(customer.country.country);

                    let tr = $('<tr>').append(id, name, mobile, email, country)

                    customerList.append(tr)
                }
            }).fail(function (data) {
                alert(data.responseText);
            })
        }

        /* Filter customer */
        let filterButtons = $('#filter>button')
        for (const button of filterButtons) {
            $(button).on('click', function () {
                listCustomers($(this).attr('name'))
            })
        }
    })
</script>
</html>
