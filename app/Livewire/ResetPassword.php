<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class ResetPassword extends Component
{
      #[\Livewire\Attributes\Layout('components.layouts.auth')]

      public $token;
      public $email = '';
      public $password = '';
      public $password_confirmation = '';

      protected $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
      ];

      protected $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
      ];

      public function mount($token)
      {
            $this->token = $token;
            $this->email = request()->query('email', '');
      }

      public function resetPassword()
      {
            $this->validate();

            try {
                  $status = Password::reset(
                        [
                              'email' => $this->email,
                              'password' => $this->password,
                              'password_confirmation' => $this->password_confirmation,
                              'token' => $this->token
                        ],
                        function ($user, $password) {
                              $user->forceFill([
                                    'password' => Hash::make($password)
                              ])->setRememberToken(Str::random(60));

                              $user->save();

                              event(new PasswordReset($user));
                        }
                  );

                  if ($status === Password::PASSWORD_RESET) {
                        Log::info('Password reset successful', ['email' => $this->email]);

                        session()->flash('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
                        return redirect()->route('login');
                  } else {
                        Log::warning('Password reset failed', [
                              'email' => $this->email,
                              'status' => $status
                        ]);

                        if ($status === Password::INVALID_TOKEN) {
                              session()->flash('error', 'Token reset password tidak valid atau sudah kadaluarsa. Silakan request ulang.');
                        } else {
                              session()->flash('error', 'Gagal mereset password. Silakan coba lagi.');
                        }
                  }
            } catch (\Exception $e) {
                  Log::error('Error resetting password: ' . $e->getMessage(), [
                        'email' => $this->email,
                        'trace' => $e->getTraceAsString()
                  ]);

                  session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
            }
      }

      public function render()
      {
            return view('livewire.reset-password');
      }
}
