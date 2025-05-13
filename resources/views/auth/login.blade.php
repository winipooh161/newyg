@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-header">
        <h2>{{ __('Вход в систему') }}</h2>
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="phone">{{ __('Номер телефона') }}</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autofocus placeholder="+7 (965) 222-44-24" class="@error('phone') error @enderror">
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
                <button type="submit" class="btn-submit">{{ __('Войти') }}</button>
            </div>
            <div class="form-group">
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">{{ __('Забыли пароль?') }}</a>
                @endif
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
