<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use App\Models\LeadAction;
use App\Models\LeadMedia;
use App\Services\LeadService;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public function index(Request $request): View
    {
        // Get filter parameters from request
        $filters = [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'city_id' => $request->get('city_id'),
            'branch_id' => $request->get('branch_id'),
            'district_id' => $request->get('district_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        // Remove empty filters
        $filters = array_filter($filters, function($value) {
            return !is_null($value) && $value !== '';
        });

        $leads = $this->leadService->getAllPaginated(15, ['city','branch','district'], $filters);

        // Get dropdown data for filters
        $cities = \App\Models\City::get();
        $branches = \App\Models\Branch::get();
        $districts = \App\Models\District::get();

        return view('dashboard.leads.index', compact('leads', 'cities', 'branches', 'districts', 'filters'));
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
        $lead->load([
            'branch',
            'city',
            'district',
            'actions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);
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

    /**
     * Store a new action for the lead.
     */
    public function storeAction(Request $request, Lead $lead)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'action_type' => 'required|in:call,email,meeting,follow_up,note',
            'action_date' => 'required|date',
            'action_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000',
        ]);

        $action = LeadAction::create([
            'lead_id' => $lead->id,
            'title' => $request->title,
            'action_type' => $request->action_type,
            'action_date' => $request->action_date,
            'action_time' => $request->action_time,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Action added successfully',
            'action' => $action->load('lead')
        ]);
    }

    /**
     * Get actions for a specific lead.
     */
    public function getActions(Lead $lead)
    {
        $actions = $lead->actions()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'actions' => $actions
        ]);
    }

    /**
     * Delete an action.
     */
    public function destroyAction(Lead $lead, LeadAction $action)
    {
        // Ensure the action belongs to the lead
        if ($action->lead_id !== $lead->id) {
            return response()->json([
                'success' => false,
                'message' => 'Action not found'
            ], 404);
        }

        $action->delete();

        return response()->json([
            'success' => true,
            'message' => 'Action deleted successfully'
        ]);
    }

    /**
     * Store uploaded media files for a lead
     */
    public function storeMedia(Request $request, $leadId)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,txt,mp3,mp4,avi,mov,wav',
            'title' => 'nullable|string|max:255',
        ]);

        $lead = Lead::findOrFail($leadId);
        $uploadedMedia = [];

        foreach ($request->file('files') as $file) {
            // Generate unique filename
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store file
            $filePath = $file->storeAs('leads/' . $leadId . '/media', $fileName, 'public');

            // Determine file type
            $mimeType = $file->getMimeType();
            $fileType = $this->determineFileType($mimeType);

            // Create media record
            $media = LeadMedia::create([
                'lead_id' => $leadId,
                'title' => $request->title,
                'original_name' => $file->getClientOriginalName(),
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
                'metadata' => [
                    'uploaded_at' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                'uploaded_by' => auth()->id(),
            ]);

            $uploadedMedia[] = [
                'id' => $media->id,
                'title' => $media->title,
                'original_name' => $media->original_name,
                'file_url' => Storage::url($media->file_path),
                'file_size_formatted' => $media->file_size_formatted,
                'file_icon' => $media->file_icon,
                'is_image' => $media->isImage(),
                'created_at' => $media->created_at->toISOString(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Media uploaded successfully',
            'media' => $uploadedMedia,
        ]);
    }

    /**
     * Delete a media file
     */
    public function destroyMedia($leadId, $mediaId)
    {
        $lead = Lead::findOrFail($leadId);
        $media = LeadMedia::where('lead_id', $leadId)->findOrFail($mediaId);

        // Delete file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        // Delete database record
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully',
        ]);
    }

    /**
     * Download a media file
     */
    public function downloadMedia($leadId, $mediaId)
    {
        $lead = Lead::findOrFail($leadId);
        $media = LeadMedia::where('lead_id', $leadId)->findOrFail($mediaId);

        if (!Storage::disk('public')->exists($media->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($media->file_path, $media->original_name);
    }

    /**
     * Determine file type based on MIME type
     */
    private function determineFileType(string $mimeType): string
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } elseif (in_array($mimeType, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
        ])) {
            return 'document';
        } elseif (in_array($mimeType, [
            'application/zip',
            'application/x-rar-compressed',
            'application/x-7z-compressed',
        ])) {
            return 'archive';
        } else {
            return 'other';
        }
    }

}
