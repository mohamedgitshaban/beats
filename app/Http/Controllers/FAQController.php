<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = FAQ::where('is_active', true)->latest()->get();
        return response()->json($faqs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'boolean',
        ]);
        $faq = FAQ::create($validatedData);
        return response()->json($faq, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $fAQ)
    {
        return response()->json($fAQ);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $fAQ)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $fAQ)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'boolean',
        ]);
        $fAQ->update($validatedData);
        return response()->json($fAQ);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $fAQ)
    {
        $fAQ->delete();
        return response()->json(null, 204);
    }
}
