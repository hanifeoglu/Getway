<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="payment-key" content="{{ $transaction->key }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrapper" id="app">

    <body class="">
    <div id="app">
        <div class="">
            <CardPaymentComponent></CardPaymentComponent>
        </div>
    </div>

</div>
<!-- partial -->
<script src='https://unpkg.com/vue-the-mask@0.11.1/dist/vue-the-mask.js'></script>
<script  src="{{mix('js/app.js')}}"></script>

</body>

</html>
