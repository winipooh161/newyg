<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Перенаправление после авторизации в зависимости от статуса пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status === 'admin') {
            return redirect()->route('feedback.index')->with('message', 'Добро пожаловать в панель администратора!');
        }
        
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Переопределение поля для аутентификации
     * 
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Валидация запроса входа
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required',
                'string',
              
            ],
            'password' => 'required|string',
        ], [
            $this->username().'.regex' => 'Номер телефона должен быть в формате: +7 (965) 222-44-24'
        ]);
    }

    // Добавлено для передачи meta-тегов в форму входа
    public function showLoginForm()
    {
        $meta_title       = 'Вход в систему';
        $meta_description = 'Авторизация зарегистрированного пользователя на сайте';
        $meta_keywords    = 'вход, логин, авторизация';
        $meta_author      = 'Название сайта';
        return view('auth.login', compact('meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }
}
