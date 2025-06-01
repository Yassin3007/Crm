<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\City;
use App\Services\BranchService;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BranchController extends Controller
{
    protected BranchService $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $branches = $this->branchService->getAllPaginated(15 , ['city']);

        return view('dashboard.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $cities = City::query()->active()->get();

        return view('dashboard.branches.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BranchRequest $request
     * @return RedirectResponse
     */
    public function store(BranchRequest $request): RedirectResponse
    {
        try {
            $this->branchService->create($request->validated());

            return redirect()->route('branches.index')
                ->with('success', 'Branch created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating Branch: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return View
     */
    public function show(Branch $branch): View
    {
        return view('dashboard.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Branch $branch
     * @return View
     */
    public function edit(Branch $branch): View
    {
        $cities = City::query()->active()->get();

        return view('dashboard.branches.edit', compact('branch',compact('cities')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BranchRequest $request
     * @param Branch $branch
     * @return RedirectResponse
     */
    public function update(BranchRequest $request, Branch $branch): RedirectResponse
    {
        try {
            $this->branchService->update($branch, $request->validated());

            return redirect()->route('branches.index')
                ->with('success', 'Branch updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating Branch: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return RedirectResponse
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        try {
            $this->branchService->delete($branch);

            return redirect()->route('branches.index')
                ->with('success', 'Branch deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting Branch: ' . $e->getMessage());
        }
    }
}
