<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SourceRequest;
use App\Services\SourceService;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SourceController extends Controller
{
    protected SourceService $sourceService;

    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $sources = $this->sourceService->getAllPaginated();

        return view('dashboard.sources.index', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SourceRequest $request
     * @return RedirectResponse
     */
    public function store(SourceRequest $request): RedirectResponse
    {
        try {
            $this->sourceService->create($request->validated());

            return redirect()->route('sources.index')
                ->with('success', 'Source created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating Source: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Source $source
     * @return View
     */
    public function show(Source $source): View
    {
        return view('dashboard.sources.show', compact('source'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Source $source
     * @return View
     */
    public function edit(Source $source): View
    {
        return view('dashboard.sources.edit', compact('source'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SourceRequest $request
     * @param Source $source
     * @return RedirectResponse
     */
    public function update(SourceRequest $request, Source $source): RedirectResponse
    {
        try {
            $this->sourceService->update($source, $request->validated());

            return redirect()->route('sources.index')
                ->with('success', 'Source updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating Source: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Source $source
     * @return RedirectResponse
     */
    public function destroy(Source $source): RedirectResponse
    {
        try {
            $this->sourceService->delete($source);

            return redirect()->route('sources.index')
                ->with('success', 'Source deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting Source: ' . $e->getMessage());
        }
    }
}
