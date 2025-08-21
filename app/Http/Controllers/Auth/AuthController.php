<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    /**
     * Summary of showLoginForm
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): View
    {
        $emails = collect(config('users', []))->pluck('email')->toArray();
        return view('auth.login', compact('emails'));
    }


    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->authService->login(data: $request->validated());
    }

    /**
     * Summary of showRegisterForm
     * @return \Illuminate\View\View
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Summary of register
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        return $this->authService->register(data: $request->validated());
    }

    /**
     * Summary of showForgotPasswordForm
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Summary of sendResetLink
     * @param \App\Http\Requests\Auth\ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        return $this->authService->sendResetLink(data: $request->validated());
    }

    /**
     * Summary of showResetForm
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(string $token): View
    {
        return view(view: 'auth.reset-password', data: compact('token'));
    }

    /**
     * Summary of resetPassword
     * @param \App\Http\Requests\Auth\ResetPasswordRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        return $this->authService->resetPassword(data: $request->validated());
    }

    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        return $this->authService->logout(request: $request);
    }
}
