<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPassword extends Component
{
      #[\Livewire\Attributes\Layout('components.layouts.auth')]

      public $email = '';

      protected $rules = [
            'email' => 'required|email|exists:users,email',
      ];

      protected $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
      ];

      public function sendResetLink()
      {
            $this->validate();

            try {
                  // Send password reset link
                  $status = Password::sendResetLink(
                        ['email' => $this->email]
                  );

                  if ($status === Password::RESET_LINK_SENT) {
                        Log::info('Password reset link sent', ['email' => $this->email]);

                        session()->flash('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
                        $this->email = '';
                  } else {
                        Log::warning('Failed to send password reset link', [
                              'email' => $this->email,
                              'status' => $status
                        ]);

                        session()->flash('error', 'Gagal mengirim link reset password. Silakan coba lagi.');
                  }
            } catch (\Exception $e) {
                  Log::error('Error sending password reset link: ' . $e->getMessage(), [
                        'email' => $this->email,
                        'trace' => $e->getTraceAsString()
                  ]);

                  session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi nanti.');
            }
      }

      public function render()
      {
            return view('livewire.forgot-password');
      }
}
