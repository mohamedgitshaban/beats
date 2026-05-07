<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'created_from' => ['nullable', 'date'],
            'created_to' => ['nullable', 'date'],
            'sort_by' => ['nullable', 'in:name,phone,created_at'],
            'sort_dir' => ['nullable', 'in:asc,desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $search = $validated['q'] ?? null;
        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDir = $validated['sort_dir'] ?? 'desc';
        $perPage = (int) ($validated['per_page'] ?? 15);

        $clients = User::clients()
            ->when($search, function ($query, $searchTerm) {
                $query->where(function ($innerQuery) use ($searchTerm) {
                    $innerQuery->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('phone', 'like', "%{$searchTerm}%");
                });
            })
            ->when(! empty($validated['created_from']), function ($query) use ($validated) {
                $query->whereDate('created_at', '>=', $validated['created_from']);
            })
            ->when(! empty($validated['created_to']), function ($query) use ($validated) {
                $query->whereDate('created_at', '<=', $validated['created_to']);
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return response()->json($clients);
    }

    public function show(int $id): JsonResponse
    {
        $client = User::clients()->findOrFail($id);

        return response()->json([
            'data' => $client,
        ]);
    }
}
