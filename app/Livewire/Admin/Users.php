<?php

namespace App\Livewire\Admin;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Users extends Component
{
    use WithPagination;

    // view states
    public $viewMode = 'list';
    public $selectedUserId;

    //filters
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    //form fields
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $role = 'user';
    public $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    //view switching
    public function switchToList()
    {
        $this->resetForm();
        $this->viewMode = 'list';
    }

    public function switchToCreate()
    {
        $this->resetForm();
        $this->viewMode = 'create';
    }

    public function switchToDetail($userId)
    {
        $this->resetForm();
        $this->selectedUserId = $userId;
        $this->viewMode = 'detail';
    }

    public function resetForm()
    {
        $this->reset([
            'selectedUserId',
            'name',
            'email',
            'phone',
            'password',
            'password_confirmation',
            'role',
            'is_active',
            'selectedUserId',
        ]);

        $this->is_active = true;
        $this->role = 'user';
    }

    public function createUser()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'User berhasil dibuat!');
        $this->switchToList();
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);

        $newPassword = 'KampungKopi' . rand(1000, 9999);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        session()->flash('success', "Password untuk {$user->name} telah direset menjadi: {$newPassword}");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->canBeDeleted()) {
            session()->flash('error', 'User tidak dapat dihapus! (mungkin karena user tersebut adalah admin yang sedang login)');
            return;
        }

        $user->delete();

        session()->flash('success', 'User berhasil dihapus!');
        $this->switchToList();
    }

    public function restoreUser($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $user->restore();

        session()->flash('success', 'User berhasil dipulihkan!');
        $this->switchToList();
    }

    public function toggleStatus($userId)
    {
        $user = User::withTrashed()->findOrFail($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        session()->flash('success', 'Status user berhasil diubah!');
    }


    #[Layout('layouts.admin')]
    public function render()
    {
        $users = User::query()
            ->withCount('bookings')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->when($this->statusFilter === 'active', fn($q) => $q->active())
            ->when($this->statusFilter === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->statusFilter === 'deleted', fn($q) => $q->onlyTrashed())
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'deleted' => User::onlyTrashed()->count(),
        ];

        $selectedUser = $this->selectedUserId
            ? User::withCount('bookings')
            ->with(['bookings' => fn($q) => $q->latest()->limit(10)])
            ->find($this->selectedUserId)
            : null;
        return view('livewire.admin.users', [
            'users' => $users,
            'stats' => $stats,
            'selectedUser' => $selectedUser,
        ]);
    }
}
