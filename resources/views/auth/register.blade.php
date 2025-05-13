@extends('layouts.app')

@section('content')
<div class="register-container">
    <div class="register-header">
        <h2>{{ __('Регистрация') }}</h2>
    </div>
    <div class="register-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Имя') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="@error('name') error @enderror">
                @error('name')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email адрес') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="@error('email') error @enderror">
                @error('email')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">{{ __('Номер телефона') }}</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+7 (965) 222-44-24" class="@error('phone') error @enderror">
                @error('phone')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">{{ __('Пароль') }}</label>
                <input id="password" type="password" name="password" required class="@error('password') error @enderror">
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">{{ __('Подтвердите пароль') }}</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-submit">{{ __('Зарегистрироваться') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>

</style>


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function(){
        $('#phone').inputmask("+7 (999) 999-99-99");
    });
</script>
@endsection
