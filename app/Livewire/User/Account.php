<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\SiteSetting;

class Account extends Component
{
    public $name;
    public $email;
    public $phone;

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $contactInfo;
    public $socialMedia;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;

        $this->loadSettings();
    }


    private function loadSettings()
    {
        // Load Contact Info
        $this->contactInfo = SiteSetting::get('contact_info', [
            'whatsapp' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
        ]);

        // Load Social Media
        $this->socialMedia = SiteSetting::get('social_media', [
            'tiktok' => '',
            'youtube' => '',
            'facebook' => '',
            'instagram' => '',
        ]);
    }


    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('success', 'Profile berhasil diperbarui!');
        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = auth()->user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password berhasil diubah!');
        $this->dispatch('password-updated');
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.account');
    }
}
