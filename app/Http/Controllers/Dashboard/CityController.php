<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Services\CityService;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $cities = $this->cityService->getAllPaginated();

        return view('dashboard.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityRequest $request
     * @return RedirectResponse
     */
    public function store(CityRequest $request): RedirectResponse
    {
        try {
            $this->cityService->create($request->validated());

            return redirect()->route('cities.index')
                ->with('success', 'City created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating City: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return View
     */
    public function show(City $city): View
    {
        return view('dashboard.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param City $city
     * @return View
     */
    public function edit(City $city): View
    {
        return view('dashboard.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest $request
     * @param City $city
     * @return RedirectResponse
     */
    public function update(CityRequest $request, City $city): RedirectResponse
    {
        try {
            $this->cityService->update($city, $request->validated());

            return redirect()->route('cities.index')
                ->with('success', 'City updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating City: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City $city
     * @return RedirectResponse
     */
    public function destroy(City $city): RedirectResponse
    {
        try {
            $this->cityService->delete($city);

            return redirect()->route('cities.index')
                ->with('success', 'City deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting City: ' . $e->getMessage());
        }
    }
}
