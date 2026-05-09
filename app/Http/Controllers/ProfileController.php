<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'This is the profile endpoint.',
            'user' => $request->user(),
        ]);
    }
    public function update(Request $request)
    {
        $data=Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:255|unique:users,phone,' . $request->user()->id,
        ]);
        if ($data->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $data->errors(),
            ], 422);
        }
        $user = $request->user();
        $user->update($request->only('name', 'phone'));
        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }
    public function destroy(Request $request)
    {
        // Delete user profile logic here
        $user = $request->user();
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => 'Profile deleted successfully.',
        ]);
    }
}
