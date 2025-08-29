<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        return User::all()->toResourceCollection();
    }

    public function show(User $user)
    {
        return $user->toResource();
    }

    public function update(User $user, Request $request)
    {
        Gate::authorize('update', $user);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user->update($data);
        return response()->json(["ok" => true, "user" => $user->toResource()], 200);
    }

    public function destroy(User $user, Request $request)
    {
        Gate::authorize('delete', $user);
        $user->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json(["ok" => true, "message" => "User has been deleted successfully"], 204);
    }
}