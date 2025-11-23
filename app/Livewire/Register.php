<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Register extends Component
{
    #[Layout('components.layouts.auth')]

    public $name;
    public $email;
    public $phone;
    public $password;


    public function render()
    {
        return view('livewire.register');
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Create the user
        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
        ]);

        // Log the user in
        \Illuminate\Support\Facades\Auth::login($user);

        // Redirect to a desired page after registration
        return redirect()->intended('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $this->name . '!');
    }
}
