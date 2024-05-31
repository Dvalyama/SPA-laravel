<?php

namespace App\Http\Controllers;

use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ValidationController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:50'], // Alex
            'last_name' => ['nullable', 'string', 'max:50'], // Gavrilenko
            'age' => ['nullable', 'integer', 'min:18', 'max:150'], // 123
            'amount' => ['required', 'numeric', 'min:1', 'max:10000000'], // 123/123.45
            'gender' => ['nullable', 'string', 'in:male,female'],
            'zip' => ['required', 'digits:6'], // 49000 индекц почты
            'subscription' => ['nullable', 'boolean'], // true/false/1/0 подписка раасылки на почту
            'agreement' => ['accepted'], // true/1/yes соглашение пользователя
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'], // Secret123!
            'current_password' => ['required', 'string', 'current_password'], // текущий пароль
            'email' => ['required', 'string', 'max:100', 'email', 'exists:users'], // mail@example.com
            'country_id' => ['required', 'integer', Rule::exists('countries', 'id')->where('active')],
            'phone' => ['required', 'string', new Phone, Rule::unique('users', 'phone')->ignore($user)],
            'website' => ['nullable', 'string', 'url'], // https://example.com
            'uuid' => ['nullable', 'string', 'uuid'], // уникальний айди
            'ip' => ['nullable', 'string', 'ip'], // 127.0.0.1
            'avatar' => ['required', 'file', 'image', 'max:1024'], // 1Mb
            'birth_date' => ['nullable', 'string', 'date'], //
            'start_date' => ['required', 'string', 'data', 'after_or_equal:today'],
            'finish_date' => ['required', 'string', 'data', 'after:start_date'],
            'services' => ['nullable', 'array', 'min:1', 'max:10'], // [1,2,3,4,5]
            'services.*' => ['required', 'integer'], // [1,2,3,4,5]
            'delivery' => ['required', 'array', 'size:2'], // ['date' => '2023-16-12', 'time' => '21:30:00']
            'delivery.date' => ['required', 'string', 'date_format:Y.m.d'], // 2023-16-12
            'delivery.time' => ['required', 'string', 'date_format:H:i:s'], // 21:30:00
            'secret' => ['required', 'string', function ($attribute, $value, \Closure $fail) {
                if ($value !== config('example.secret')) {
                    $fail(__('Невірний секретний ключ.'));
                }
            }],
        ]);

        dd($validated);
    }
}
