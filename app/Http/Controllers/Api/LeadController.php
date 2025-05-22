<?php

namespace app\Http\Controllers\Api;

use App\Enums\LeadStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Notifications\LeadStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $leads = Lead::query()->with('manager');
        if ($request->filled('search')) {
            $leads->where('name', 'like', '%' . $request->input('search') . '%');
        }
        if ($request->filled('status')) {
            $leads->where('status', $request->input('status'));
        }
        return response()->json(['data' => $leads->paginate()]);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'car' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'manager_id' => 'nullable|integer'
        ]);
       $lead = Lead::create($validated);
        return response()->json(['message' => 'Lead created successfully.',
            'data' => $lead
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return response()->json(['data' => $lead->load('manager')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }

    public function changeStatus(Lead $lead): \Illuminate\Http\JsonResponse
    {
        $validated = request()->validate([
            'status' => 'required|string|max:255',
            'manager_id' => Rule::requiredIf($lead->manager()->doesntExist())
        ]);
        $lead->update($validated);
        return response()->json(['message' => 'Lead status updated successfully.']);
    }
}
