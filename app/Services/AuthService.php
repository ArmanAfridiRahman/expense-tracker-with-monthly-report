<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class AuthService
{
     /**
      * Summary of login
      * @param array $data
      * @return RedirectResponse
      */
     public function login(array $data): RedirectResponse
     {
          $attempt = Auth::guard("web")->attempt([
               'email'    => Arr::get($data, 'email'),
               'password' => Arr::get($data, 'password')
          ], (bool) Arr::get($data, 'remember'));
          
          if ($attempt) {
          
               session()->regenerate();
               return redirect()->route('dashboard')->with("success", "Successfully Logged In");
          }
          return back()->with("error", "Invalid Credentials");
     }

     /**
      * Summary of register
      * @param array $data
      * @return RedirectResponse
      */
     public function register(array $data): RedirectResponse
     {
          $user = User::create([
               'name'     => Arr::get($data, "name"),
               'email'    => Arr::get($data,'email'),
               'password' => Hash::make(Arr::get($data,'password')),
          ]);

          Auth::login($user);
          return redirect()->route('dashboard')->with("success", "Successfully Logged In");
     }

     /**
      * Summary of sendResetLink
      * @param array $data
      * @return RedirectResponse
      */
     public function sendResetLink(array $data): RedirectResponse
     {
          try {
               $email    = Arr::get($data, 'email');
               $user     = User::where('email', $email)->first();
               if (!$user) return back()->with('error', 'No user found with this email address.');

               $token    = Password::createToken($user);
               $url      = route('password.reset', ['token' => $token, 'email' => $user->email]);
               
               Mail::to($user->email)->send(new PasswordResetMail($url));
               
               if (Mail::failures()) return back()->with('error', 'Failed to send password reset email. Please try again.');
               
               
               return back()->with('success', 'Password reset link has been sent to your email address!');
               
          } catch (\Exception $e) {

               return back()->with('error', 'Failed to send password reset email. Please contact support if the problem persists.');
          }
     }

     /**
      * Summary of resetPassword
      * @param array $data
      * @return RedirectResponse
      */
     public function resetPassword(array $data): RedirectResponse
     {
          $status = Password::reset(
          credentials: [
               'email'        => Arr::get($data,'email'), 
               'token'        => Arr::get($data,'token'), 
               'password'     => Arr::get($data, 'password')
          ],
          callback: function (User $user, $password) {
               $user->forceFill([
                    'password' => Hash::make($password)
               ])->save();
          });

          return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Password reset successful!')
                    : back()->withErrors(['email' => __($status)]);
     }

     /**
      * Summary of logout
      * @param \Illuminate\Http\Request $request
      * @return RedirectResponse
      */
     public function logout(Request $request): RedirectResponse
     {
          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();
          return redirect()->route('login')->with('success', 'Successfully logged out');
     }
}
