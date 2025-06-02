@extends('dashboard.layouts.master')

@section('content')
    <!-- Content section -->
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.lead.view') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('leads.index') }}">{{ __('dashboard.lead.list') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.lead.view') }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <!-- Lead Information Card -->
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="icon-user"></i> {{ __('dashboard.lead.title') }} {{ __('dashboard.common.information') }}
                                </h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a href="{{ route('leads.edit', $lead->id) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="icon-pencil"></i> {{ __('dashboard.common.edit') }}
                                            </a>
                                        </li>
                                        <li><a href="{{ route('leads.index') }}" class="btn btn-sm btn-secondary">
                                                <i class="icon-arrow-left4"></i> {{ __('dashboard.common.back') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body col-md-12">
                                <div class="row">
                                    <!-- Personal Information -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3 mt-1">
                                            <i class="icon-user"></i> Personal Information
                                        </h5>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.common.id") }}:</label>
                                            <span class="badge badge-primary">#{{ $lead->id }}</span>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.name") }}:</label>
                                            <p class="mb-0">{{ $lead->name }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.phone") }}:</label>
                                            <p class="mb-0">
                                                <a href="tel:{{ $lead->phone }}" class="text-success">
                                                    <i class="icon-phone"></i> {{ $lead->phone }}
                                                </a>
                                            </p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.whatsapp_number") }}:</label>
                                            <p class="mb-0">
                                                <a href="https://wa.me/{{ $lead->whatsapp_number }}" target="_blank" class="text-success">
                                                    <i class="icon-social-whatsapp"></i> {{ $lead->whatsapp_number }}
                                                </a>
                                            </p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.email") }}:</label>
                                            <p class="mb-0">
                                                <a href="mailto:{{ $lead->email }}" class="text-info">
                                                    <i class="icon-envelope"></i> {{ $lead->email }}
                                                </a>
                                            </p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.national_id") }}:</label>
                                            <p class="mb-0">{{ $lead->national_id }}</p>
                                        </div>
                                    </div>

                                    <!-- Location Information -->
                                    <div class="col-md-6">
                                        <h5 class="text-primary mb-3 mt-1">
                                            <i class="icon-location-pin"></i> Location Information
                                        </h5>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.branch.title") }}:</label>
                                            <p class="mb-0">
                                                <span class="badge badge-info">{{ $lead->branch->name }}</span>
                                            </p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.city.title") }}:</label>
                                            <p class="mb-0">{{ $lead->city->name }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.district.title") }}:</label>
                                            <p class="mb-0">{{ $lead->district->name }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="font-weight-bold text-muted">{{ __("dashboard.lead.fields.location_link") }}:</label>
                                            <p class="mb-0">
                                                <a href="{{ $lead->location_link }}" target="_blank" class="text-warning">
                                                    <i class="icon-map"></i> View on Map
                                                </a>
                                            </p>
                                        </div>

                                        <!-- Timestamps -->
                                        <div class="mt-4">
                                            <h6 class="text-muted">Record Information</h6>
                                            <small class="text-muted d-block">
                                                <i class="icon-calendar"></i> Created: {{ $lead->created_at->format('Y-m-d H:i:s') }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="icon-clock"></i> Updated: {{ $lead->updated_at->format('Y-m-d H:i:s') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#actionModal">
                                            <i class="icon-plus"></i> Add Action
                                        </button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                              class="delete-form d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-btn">
                                                <i class="icon-trash"></i> {{ __('dashboard.common.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Log Card -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="icon-list"></i> Actions Log
                                </h4>
                            </div>
                            <div class="card-body">
                                <div id="actions-log">
                                    @if(isset($lead->actions) && $lead->actions->count() > 0)
                                        @foreach($lead->actions as $action)
                                            <div class="action-item mb-3 p-3 border-left border-primary bg-light">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h6 class="mb-1 text-primary">{{ $action->title }}</h6>
                                                    <small class="text-muted">{{ $action->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-1">
                                                    <span class="badge badge-{{ $action->action_type == 'call' ? 'success' : ($action->action_type == 'email' ? 'info' : 'warning') }}">
                                                        {{ ucfirst($action->action_type) }}
                                                    </span>
                                                </p>
                                                @if($action->notes)
                                                    <p class="mb-1 text-muted small">{{ $action->notes }}</p>
                                                @endif
                                                <small class="text-muted">
                                                    <i class="icon-calendar"></i> {{ $action->action_date->format('Y m d') }} at {{ $action->action_time }}
                                                </small>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="icon-info font-large-1"></i>
                                            <p class="mt-2">No actions recorded yet.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Management Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="icon-folder"></i> Media Files
                                </h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mediaModal">
                                                <i class="icon-upload"></i> Upload Media
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="media-grid" class="row">
                                    @if(isset($lead->media) && $lead->media->count() > 0)
                                        @foreach($lead->media as $media)
                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-media-id="{{ $media->id }}">
                                                <div class="media-item card h-100">
                                                    <div class="media-preview">
                                                        @if($media->isImage())
                                                            <img src="{{ Storage::url($media->file_path) }}" alt="{{ $media->original_name }}" class="card-img-top media-thumbnail">
                                                        @else
                                                            <div class="card-img-top media-file-icon d-flex align-items-center justify-content-center">
                                                                <i class="{{ $media->file_icon }} font-large-2 text-primary"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title mb-2 text-truncate" title="{{ $media->title ?: $media->original_name }}">
                                                            {{ $media->title ?: $media->original_name }}
                                                        </h6>
                                                        <p class="card-text small text-muted mb-2">
                                                            <i class="icon-file"></i> {{ $media->file_size_formatted }}
                                                        </p>
                                                        <small class="text-muted d-block mb-2">
                                                            <i class="icon-calendar"></i> {{ $media->created_at->format('M d, Y') }}
                                                        </small>
                                                    </div>
                                                    <div class="card-footer p-2 bg-light">
                                                        <div class="btn-group btn-group-sm w-100" role="group">
                                                            <a href="{{ route('leads.media.download', [$lead->id, $media->id]) }}"
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="icon-download"></i>
                                                            </a>
                                                            @if($media->isImage())
                                                                <button type="button" class="btn btn-outline-info btn-sm preview-btn"
                                                                        data-image-url="{{ Storage::url($media->file_path) }}"
                                                                        data-title="{{ $media->title ?: $media->original_name }}">
                                                                    <i class="icon-eye"></i>
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-outline-danger btn-sm delete-media-btn"
                                                                    data-media-id="{{ $media->id }}"
                                                                    data-media-name="{{ $media->original_name }}">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <div class="text-center text-muted py-5" id="no-media-message">
                                                <i class="icon-folder font-large-2"></i>
                                                <p class="mt-3">No media files uploaded yet.</p>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mediaModal">
                                                    <i class="icon-upload"></i> Upload Your First File
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Modal -->
    <div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="actionModalLabel">
                        <i class="icon-plus"></i> Add New Action
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="actionForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="action_type" class="form-label">Action Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="action_type" name="action_type" required>
                                        <option value="">Select Action Type</option>
                                        <option value="call">Phone Call</option>
                                        <option value="email">Email</option>
                                        <option value="meeting">Meeting</option>
                                        <option value="follow_up">Follow Up</option>
                                        <option value="note">Note</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="action_date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="action_date" name="action_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="action_time" class="form-label">Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="action_time" name="action_time" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Add any additional notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="icon-check"></i> Save Action
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Media Upload Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mediaModalLabel">
                        <i class="icon-upload"></i> Upload Media Files
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="mediaForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="media_title" class="form-label">Title (Optional)</label>
                            <input type="text" class="form-control" id="media_title" name="title" placeholder="Enter a title for these files">
                        </div>

                        <div class="form-group">
                            <label for="media_files" class="form-label">Select Files <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file" id="media_files" name="files[]" multiple required
                                   accept=".jpeg,.jpg,.png,.gif,.svg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.mp3,.mp4,.avi,.mov,.wav">
                            <small class="form-text text-muted">
                                Allowed file types: Images, Documents, Archives, Audio, Video. Max size: 10MB per file.
                            </small>
                        </div>

                        <div id="file-preview" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="icon-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="icon-upload"></i> Upload Files
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="imagePreviewModalLabel">Image Preview</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="" class="img-fluid" id="preview-image">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script>
        $(document).ready(function () {
            // Set default date and time
            const now = new Date();
            $('#action_date').val(now.toISOString().split('T')[0]);
            $('#action_time').val(now.toTimeString().split(' ')[0].substring(0, 5));

            // Delete confirmation
            $('.delete-btn').on('click', function (e) {
                e.preventDefault();
                if (confirm('{{ __("dashboard.lead.delete_confirm") }}')) {
                    $(this).closest('form').submit();
                }
            });

            // Action form submission
            $('#actionForm').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const submitBtn = $(this).find('button[type="submit"]');
                const originalBtnText = submitBtn.html();

                // Show loading state
                submitBtn.prop('disabled', true).html('<i class="icon-spinner"></i> Saving...');

                $.ajax({
                    url: '{{ route("leads.actions.store", $lead->id) }}',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            // Close modal
                            $('#actionModal').modal('hide');

                            // Reset form
                            $('#actionForm')[0].reset();
                            const now = new Date();
                            $('#action_date').val(now.toISOString().split('T')[0]);
                            $('#action_time').val(now.toTimeString().split(' ')[0].substring(0, 5));

                            // Add new action to log
                            addActionToLog(response.action);

                            // Show success message
                            showNotification('Action added successfully!', 'success');
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorMessage = 'Please fix the following errors:\n';
                            Object.values(errors).forEach(error => {
                                errorMessage += '- ' + error[0] + '\n';
                            });
                            alert(errorMessage);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    complete: function () {
                        // Reset button state
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Media file selection preview
            $('#media_files').on('change', function () {
                const files = this.files;
                const preview = $('#file-preview');
                preview.empty();

                if (files.length > 0) {
                    preview.append('<h6>Selected Files:</h6><ul class="list-unstyled">');
                    Array.from(files).forEach(function (file) {
                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        preview.find('ul').append(`<li class="mb-1"><i class="icon-file"></i> ${file.name} (${fileSize} MB)</li>`);
                    });
                    preview.append('</ul>');
                }
            });

            // Media form submission
            $('#mediaForm').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = $(this).find('button[type="submit"]');
                const originalBtnText = submitBtn.html();

                // Show loading state
                submitBtn.prop('disabled', true).html('<i class="icon-spinner"></i> Uploading...');

                $.ajax({
                    url: '{{ route("leads.media.store", $lead->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            // Close modal
                            $('#mediaModal').modal('hide');

                            // Reset form
                            $('#mediaForm')[0].reset();
                            $('#file-preview').empty();

                            // Add new media to grid
                            response.media.forEach(function (media) {
                                addMediaToGrid(media);
                            });

                            // Hide "no media" message if it exists
                            $('#no-media-message').parent().remove();

                            // Show success message
                            showNotification('Media uploaded successfully!', 'success');
                        }
                    },
                    error: function (xhr) {
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            let errorMessage = 'Please fix the following errors:\n';
                            Object.values(errors).forEach(error => {
                                errorMessage += '- ' + error[0] + '\n';
                            });
                            alert(errorMessage);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    complete: function () {
                        // Reset button state
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Delete media
            $(document).on('click', '.delete-media-btn', function () {
                const mediaId = $(this).data('media-id');
                const mediaName = $(this).data('media-name');
                const mediaElement = $(this).closest('[data-media-id]');

                if (confirm(`Are you sure you want to delete "${mediaName}"?`)) {
                    $.ajax({
                        url: '{{ route("leads.media.destroy", [$lead->id, ":mediaId"]) }}'.replace(':mediaId', mediaId),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                mediaElement.fadeOut(300, function () {
                                    $(this).remove();

                                    // Show "no media" message if no media left
                                    if ($('#media-grid [data-media-id]').length === 0) {
                                        $('#media-grid').html(`
                                            <div class="col-12">
                                                <div class="text-center text-muted py-5" id="no-media-message">
                                                    <i class="icon-folder font-large-2"></i>
                                                    <p class="mt-3">No media files uploaded yet.</p>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mediaModal">
                                                        <i class="icon-upload"></i> Upload Your First File
                                                    </button>
                                                </div>
                                            </div>
                                        `);
                                    }
                                });
                                showNotification('Media deleted successfully!', 'success');
                            }
                        },
                        error: function () {
                            alert('An error occurred while deleting the media.');
                        }
                    });
                }
            });

            // Image preview
            $(document).on('click', '.preview-btn', function () {
                const imageUrl = $(this).data('image-url');
                const title = $(this).data('title');

                $('#imagePreviewModalLabel').text(title);
                $('#preview-image').attr('src', imageUrl).attr('alt', title);
                $('#imagePreviewModal').modal('show');
            });

            function addActionToLog(action) {
                const actionBadgeClass = getActionBadgeClass(action.action_type);
                const actionHtml = `
                    <div class="action-item mb-3 p-3 border-left border-primary bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="mb-1 text-primary">${action.title}</h6>
                            <small class="text-muted">just now</small>
                        </div>
                        <p class="mb-1">
                            <span class="badge badge-${actionBadgeClass}">
                                ${action.action_type.charAt(0).toUpperCase() + action.action_type.slice(1).replace('_', ' ')}
                            </span>
                        </p>
                        ${action.notes ? `<p class="mb-1 text-muted small">${action.notes}</p>` : ''}
                        <small class="text-muted">
                            <i class="icon-calendar"></i> ${action.action_date} at ${action.action_time}
                        </small>
                    </div>
                `;

                // If no actions exist, replace the "no actions" message
                const noActionsMsg = $('#actions-log .text-center');
                if (noActionsMsg.length) {
                    noActionsMsg.remove();
                }

                $('#actions-log').prepend(actionHtml);
            }

            function addMediaToGrid(media) {
                const mediaHtml = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-media-id="${media.id}">
                        <div class="media-item card h-100">
                            <div class="media-preview">
                                ${media.is_image ?
                    `<img src="${media.file_url}" alt="${media.original_name}" class="card-img-top media-thumbnail">` :
                    `<div class="card-img-top media-file-icon d-flex align-items-center justify-content-center">
                                        <i class="${media.file_icon} font-large-2 text-primary"></i>
                                    </div>`
                }
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2 text-truncate" title="${media.title || media.original_name}">
                                    ${media.title || media.original_name}
                                </h6>
                                <p class="card-text small text-muted mb-2">
                                    <i class="icon-file"></i> ${media.file_size_formatted}
                                </p>
                                <small class="text-muted d-block mb-2">
                                    <i class="icon-calendar"></i> ${new Date(media.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}
                                </small>
                            </div>
                            <div class="card-footer p-2 bg-light">
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <a href="{{ route('leads.media.download', [$lead->id, ':mediaId']) }}".replace(':mediaId', media.id)
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="icon-download"></i>
                                    </a>
                                    ${media.is_image ?
                    `<button type="button" class="btn btn-outline-info btn-sm preview-btn"
                                                data-image-url="${media.file_url}"
                                                data-title="${media.title || media.original_name}">
                                            <i class="icon-eye"></i>
                                        </button>` : ''
                }
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-media-btn"
                                            data-media-id="${media.id}"
                                            data-media-name="${media.original_name}">
                                        <i class="icon-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#media-grid').prepend(mediaHtml);
            }

            function getActionBadgeClass(actionType) {
                const badgeClasses = {
                    'call': 'success',
                    'email': 'info',
                    'meeting': 'warning',
                    'follow_up': 'primary',
                    'note': 'secondary'
                };
                return badgeClasses[actionType] || 'secondary';
            }

            function showNotification(message, type) {
                // You can implement your preferred notification system here
                // For now, we'll use a simple alert
                alert(message);
            }
        });
    </script>
@endsection

@section('page_styles')
    <style>
        .info-item {
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 0.5rem;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .action-item {
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }

        .action-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .badge {
            font-size: 0.75em;
        }

        .border-left {
            border-left: 3px solid #007bff !important;
        }

        /* Media Section Styles */
        .media-item {
            transition: all 0.3s ease;
            border: 1px solid #e3e6f0;
        }

        .media-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .media-thumbnail {
            height: 150px;
            object-fit: cover;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .media-file-icon {
            height: 150px;
            background: #f8f9fa;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .media-preview {
            overflow: hidden;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        #media-grid .card-title {
            font-size: 0.9rem;
            line-height: 1.2;
        }

        #media-grid .card-text {
            font-size: 0.75rem;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* File preview in upload modal */
        #file-preview {
            background: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1rem;
            border: 1px solid #e3e6f0;
        }

        #file-preview ul {
            margin-bottom: 0;
        }

        #file-preview li {
            padding: 0.25rem 0;
            color: #6c757d;
        }

        /* Image preview modal */
        #imagePreviewModal .modal-dialog {
            max-width: 800px;
        }

        #preview-image {
            max-height: 70vh;
            border-radius: 0.375rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .media-thumbnail,
            .media-file-icon {
                height: 120px;
            }

            #media-grid .col-lg-3,
            #media-grid .col-md-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            #media-grid .col-lg-3,
            #media-grid .col-md-4,
            #media-grid .col-sm-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .icon-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection
