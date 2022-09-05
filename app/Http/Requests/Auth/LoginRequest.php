<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => ['required'],
            'password' => ['required'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate( $request )
    {
        $this->ensureIsNotRateLimited();

        $isEmail = filter_var($request->login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';

        if ( !Auth::attempt([$isEmail => $request->login, 'password' => $request->password], $this->boolean('remember')) )
        {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /***
     * Custom validation messages
    */
    public function messages()
    {
        return [
            'login.required' => 'Username/email must not be empty',
            'password.required' => 'Password must not be empty'
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }

    /**
     * check if the user is active
     *
     * @return string
     */
    public function isUserStatusActive()
    {
        if(!auth()->user()->is_active)
        {
            Auth::guard('web')->logout();

            // throw ValidationException::withMessages([
            //     'message' => ['Account is not activated yet. Please contact administrator']
            // ]);

            throw ValidationException::withMessages([
                'email' => ['Account is not activated yet. Please contact administrator']
            ]);

        }
    }
}
