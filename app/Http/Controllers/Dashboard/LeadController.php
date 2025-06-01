<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Services\LeadService;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    protected LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $leads = $this->leadService->getAllPaginated(15,['city','branch','district']);

        return view('dashboard.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $branches = Branch::query()->active()->get();
        $cities = City::query()->active()->get();
        $districts = District::query()->active()->get();
        return view('dashboard.leads.create',compact('branches','cities','districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeadRequest $request
     * @return RedirectResponse
     */
    public function store(LeadRequest $request): RedirectResponse
    {
        try {
            $this->leadService->create($request->validated());

            return redirect()->route('leads.index')
                ->with('success', 'Lead created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating Lead: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Lead $lead
     * @return View
     */
    public function show(Lead $lead): View
    {
        return view('dashboard.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Lead $lead
     * @return View
     */
    public function edit(Lead $lead): View
    {
        $branches = Branch::query()->active()->get();
        $cities = City::query()->active()->get();
        $districts = District::query()->active()->get();
        return view('dashboard.leads.edit', compact('lead','branches','cities','districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeadRequest $request
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function update(LeadRequest $request, Lead $lead): RedirectResponse
    {
        try {
            $this->leadService->update($lead, $request->validated());

            return redirect()->route('leads.index')
                ->with('success', 'Lead updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating Lead: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lead $lead
     * @return RedirectResponse
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        try {
            $this->leadService->delete($lead);

            return redirect()->route('leads.index')
                ->with('success', 'Lead deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting Lead: ' . $e->getMessage());
        }
    }
}
