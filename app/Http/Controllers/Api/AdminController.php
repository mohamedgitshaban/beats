<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('q')->toString();
        $perPage = min((int) $request->integer('per_page', 15), 100);

        $admins = User::admins()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($admins);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);

        $admin = User::create([
            'name' => $validated['name'],
            'phone' => $normalizedPhone,
            'email' => $normalizedPhone.'@phone.local',
            'password' => str()->random(40),
            'role' => User::ROLE_ADMIN,
        ]);

        return response()->json([
            'message' => 'Admin created successfully.',
            'data' => $admin,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $admin = User::admins()->findOrFail($id);

        return response()->json([
            'data' => $admin,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $admin = User::admins()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:20', 'unique:users,phone,'.$admin->id],
        ]);

        if (array_key_exists('phone', $validated)) {
            $validated['phone'] = preg_replace('/\D+/', '', $validated['phone']);
            $validated['email'] = $validated['phone'].'@phone.local';
        }

        $admin->update($validated);

        return response()->json([
            'message' => 'Admin updated successfully.',
            'data' => $admin,
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $admin = User::admins()->findOrFail($id);

        if ($request->user()->id === $admin->id) {
            return response()->json([
                'message' => 'You cannot delete your own admin account.',
            ], 422);
        }

        $admin->delete();

        return response()->json([
            'message' => 'Admin deleted successfully.',
        ]);
    }
}
