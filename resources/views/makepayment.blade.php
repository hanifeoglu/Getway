<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container p-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ödeme Yap</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('payments.store')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Ad Soyad') }}</label>

                                <div class="col-md-6">
                                    <input id="name" disabled type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $transaction->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="email"  class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" disabled type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $transaction->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Telefon') }}</label>

                                <div class="col-md-6">
                                    <input id="name" disabled type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $transaction->phone }}" required autocomplete="phone" >

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Hizmet Türü') }}</label>

                                <div class="col-md-6">
                                    <input id="name" disabled type="text" class="form-control @error('product') is-invalid @enderror" name="description" value="{{ $transaction->description }}" required autocomplete="description" >

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tutar') }}</label>

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <input id="name"  type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ sprintf("%01.2f",$transaction->amount) }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">$</span>
                                        </div>
                                    </div>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full name (on the card)') }}</label>

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <input id="cc_name"  type="text" class="form-control @error('cc_name') is-invalid @enderror" name="cc_name" value="{{ old("cc_name") }}" required>
                                    </div>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Card Number') }}</label>

                                <div class="col-md-6">

                                    <div class="input-group mb-3">
                                        <input id="cc_no"  type="text" class="form-control @error('cc_no') is-invalid @enderror" name="cc_name" value="{{ old("cc_name") }}" required>
                                    </div>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Expiration') }}</label>

                                <div class="col-md-3">

                                    <div class="input-group mb-3">
                                        <input id="exp_month"  type="number" min="1" max="12" class="form-control @error('exp_month') is-invalid @enderror" name="exp_month" value="{{ old("exp_month") }}" required>
                                        <input id="exp_year"  type="number" min="{{date("Y")}}" max="{{date("Y") + 10 }}" class="form-control @error('exp_year') is-invalid @enderror" name="exp_year" value="{{ old("exp_year") }}" required>
                                    </div>

                                    @error('exp_month')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Ödeme Yap') }}
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
