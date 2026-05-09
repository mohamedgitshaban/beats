<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Otp;
use Illuminate\Http\Request;

class ClientAuthController extends Controller
{
    public function signup(Request $request)
    {
       
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
        ]);
        // Create a new client user
        $client = Client::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
        ]);
        Otp::updateOrCreate(
            ['user_id' => $client->id],[
            'otp_code' => '12345',
            'expires_at' => now()->addMinutes(10),
        ]);
        // Return a success response
        return response()->json([
            'message' => 'Client registered successfully',
            'client' => $client,
        ], 201);
    }
    public function verifyOtp(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|max:6',
        ]);

        // Find the client by phone number
        $client = Client::where('phone', $validatedData['phone'])->first();

        if (! $client) {
            return response()->json([
                'message' => 'Client not found.',
            ], 404);
        }

        // Check if the OTP is valid and not expired
        if ($client->otp->otp_code !== $validatedData['otp'] || now()->greaterThan($client->otp->expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }

        // Mark the client as verified
        $client->phone_verified_at = now();
        $client->otp->delete(); // Clear the OTP
        $client->status = 'active';
        $token = $client->createToken('api-token')->plainTextToken;
        $client->save();

        // Return a success response
        return response()->json([
            'message' => 'OTP verified successfully. Client is now verified.',
            'token' => $token,
            'client' => $client,
        ]);
    }
    public function sendOtp(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        // Find the client by phone number
        $client = Client::where('phone', $validatedData['phone'])->first();

        if (! $client) {
            return response()->json([
                'message' => 'Client not found.',
            ], 404);
        }

        // Generate and save a new OTP
        Otp::updateOrCreate(
            ['user_id' => $client->id],[
            'otp_code' => '12345',
            'expires_at' => now()->addMinutes(10),
        ]);

        // Return a success response
        return response()->json([
            'message' => 'OTP sent successfully.',
        ]);
    }
    public function login(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|max:5',
        ]);
        // Find the client by phone number
        $client = Client::where('phone', $validatedData['phone'])->first();
        if (! $client) {
            return response()->json([
                'message' => 'Client not found.',
            ], 404);
        }
        // Check if the OTP is valid and not expired
        if ($client->otp->otp_code !== $validatedData['otp'] || now()->greaterThan($client->otp->expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }
        $client->otp->delete(); // Clear the OTP
        $token = $client->createToken('api-token')->plainTextToken;
        // Return a success response
        return response()->json([
            'message' => 'Login successful. Client is now verified.',
            'client' => $client,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
