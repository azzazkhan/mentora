<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Paginator;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Auth\Enums\Role;
use Modules\User\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $paginator = Paginator::fromRequest($request);

        $users = User::query()
            ->with(['roles'])
            ->take($paginator->perPage)
            ->skip($paginator->perPage * ($paginator->page - 1))
            ->get();

        $roles = collect(Role::cases())->map(fn(Role $role) => [
            'value' => $role->value,
            'label' => $role->getLabel(),
        ]);

        return Inertia::render('dashboard/users/index', [
            'users' => UserResource::collection($users),
            'roles' => $roles->all(),
        ]);
    }

    public function create()
    {
        $roles = collect(Role::cases())->map(fn(Role $role) => [
            'value' => $role->value,
            'label' => $role->getLabel(),
        ]);

        return Inertia::render('dashboard/users/create', [
            'roles' => $roles->all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('dashboard/users/show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('dashboard/users/edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', 'User deleted successfully');
    }
}
