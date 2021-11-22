@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
{{--                <div class="card-header">{{ __('Register') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('register') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">--}}

{{--                                @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Register') }}--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}


                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.8.0/dist/css/uikit.min.css" />

                <div class="registration__container">
                    <div class="registration__aligner">
                        <h2 class="registration__title">{{ __('Реєстрація') }}</h2>
                    </div>
                    <div class="registration__inner">
                        <div class="registration__aligner">
                            <div class="registration__aligner__inner">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf


                                    <div class="row">
                                        {{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                                        <div class="registration__email__container">
                                            <div class="registration__email__inner">
                                                {{--                                                <input id="email" type="email" class="registration__input @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}
                                                <input id="surname" type="text" class="registration__input @error('surname') is-invalid @enderror" name="surname" placeholder="Прізвище" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                                                @error('surname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                                        <div class="registration__email__container">
                                            <div class="registration__email__inner">
{{--                                                <input id="email" type="email" class="registration__input @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}
                                                <input id="name" type="text" class="registration__input @error('name') is-invalid @enderror" name="name" placeholder="Ім'я" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                                        <div class="registration__email__container">
                                            <div class="registration__email__inner">
                                                {{--                                                <input id="email" type="email" class="registration__input @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}
                                                <input id="email" type="email" class="registration__input @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{--                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                                        <div class="registration__email__container">
                                            <div class="registration__email__inner">
                                                <input id="password" type="password" class="registration__input @error('password') is-invalid @enderror" name="password" placeholder="Пароль" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{--                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                                        <div class="registration__email__container">
                                            <div class="registration__email__inner">
                                                {{--                                                <input id="email" type="email" class="registration__input @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}
                                                <input id="password-confirm" type="password" class="registration__input" name="password_confirmation" placeholder="Підтвердіть пароль" required autocomplete="new-password">

                                            </div>
                                        </div>
                                    </div>





                                    <button type="submit" class="registration__submit-btn">
                                        {{ __('Зареєструватися') }}
                                    </button>



                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="registration__redirect__container">
                    <div class="registration__redirect__inner">
                        <a href="{{ route('login') }}">Я уже зареєстрований</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
