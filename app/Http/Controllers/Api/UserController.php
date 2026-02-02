<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => User::all()
        ]);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        $user->update($data);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted'
        ]);
    }
}
