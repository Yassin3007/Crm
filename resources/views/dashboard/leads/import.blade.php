@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.lead.import') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('leads.index') }}">{{ __('dashboard.lead.title') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.common.import') }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('dashboard.lead.import_excel') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-block">

                                    {{-- Instructions --}}
                                    <div class="alert alert-info">
                                        <h5><i class="icon-info"></i> {{ __('dashboard.common.instructions') }}</h5>
                                        <ul class="mb-0">
                                            <li>{{ __('dashboard.lead.import_instruction_1') }}</li>
                                            <li>{{ __('dashboard.lead.import_instruction_2') }}</li>
                                            <li>{{ __('dashboard.lead.import_instruction_3') }}</li>
                                            <li>{{ __('dashboard.lead.import_instruction_4') }}</li>
                                        </ul>
                                    </div>

                                    {{-- Download Template --}}
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="alert alert-warning">
                                                <h6><i class="icon-download"></i> {{ __('dashboard.common.download_template') }}</h6>
                                                <p class="mb-1">{{ __('dashboard.lead.download_template_instruction') }}</p>
                                                <a href="{{ route('leads.template.download') }}" class="btn btn-warning btn-sm">
                                                    <i class="icon-download"></i> {{ __('dashboard.common.download_template') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Import Form --}}
                                    <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                                        @csrf

                                        <div class="form-group">
                                            <label for="file">{{ __('dashboard.common.select_file') }} <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input @error('file') is-invalid @enderror"
                                                       id="file"
                                                       name="file"
                                                       accept=".xlsx,.xls,.csv"
                                                       required>
                                                <label class="custom-file-label" for="file">{{ __('dashboard.common.choose_file') }}</label>
                                            </div>
                                            @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                {{ __('dashboard.common.accepted_formats') }}: .xlsx, .xls, .csv
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="skip_header" name="skip_header" value="1" checked>
                                                <label class="custom-control-label" for="skip_header">
                                                    {{ __('dashboard.common.skip_first_row') }}
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('dashboard.common.skip_first_row_help') }}
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="update_existing" name="update_existing" value="1">
                                                <label class="custom-control-label" for="update_existing">
                                                    {{ __('dashboard.common.update_existing') }}
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('dashboard.lead.update_existing_help') }}
                                            </small>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success" id="importBtn">
                                                <i class="icon-upload"></i> {{ __('dashboard.common.import') }}
                                            </button>
                                            <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                                <i class="icon-arrow-left"></i> {{ __('dashboard.common.back') }}
                                            </a>
                                        </div>
                                    </form>

                                    {{-- Progress Bar (Hidden by default) --}}
                                    <div class="progress mt-3" id="progressBar" style="display: none;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar"
                                             style="width: 0%"
                                             id="progressBarInner">
                                            0%
                                        </div>
                                    </div>

                                    {{-- Column Mapping Help --}}
                                    <div class="mt-4">
                                        <h5>{{ __('dashboard.common.expected_columns') }}</h5>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('dashboard.common.column_name') }}</th>
                                                    <th>{{ __('dashboard.common.required') }}</th>
                                                    <th>{{ __('dashboard.common.description') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><code>name</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.name_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>phone</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.phone_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>whatsapp_number</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.whatsapp_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>email</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.email_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>national_id</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.national_id_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>branch_id</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.branch_id_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>city_id</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.city_id_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>district_id</code></td>
                                                    <td><span class="badge badge-danger">{{ __('dashboard.common.required') }}</span></td>
                                                    <td>{{ __('dashboard.lead.district_id_description') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><code>location_link</code></td>
                                                    <td><span class="badge badge-warning">{{ __('dashboard.common.optional') }}</span></td>
                                                    <td>{{ __('dashboard.lead.location_link_description') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script>
        $(document).ready(function() {
            // Update file input label when file is selected
            $('#file').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // Handle form submission with progress
            $('#importForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var submitBtn = $('#importBtn');
                var progressBar = $('#progressBar');
                var progressBarInner = $('#progressBarInner');

                // Disable submit button and show progress
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> {{ __("dashboard.common.importing") }}...');
                progressBar.show();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                progressBarInner.css('width', percentComplete + '%').text(percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            toastr.success(response.message || '{{ __("dashboard.common.import_success") }}');

                            // Redirect after a short delay
                            setTimeout(function() {
                                window.location.href = '{{ route("leads.index") }}';
                            }, 1500);
                        } else {
                            toastr.error(response.message || '{{ __("dashboard.common.import_error") }}');
                            resetForm();
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = '{{ __("dashboard.common.import_error") }}';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('<br>');
                        }

                        toastr.error(errorMessage);
                        resetForm();
                    }
                });
            });

            function resetForm() {
                var submitBtn = $('#importBtn');
                var progressBar = $('#progressBar');
                var progressBarInner = $('#progressBarInner');

                // Reset button and hide progress
                submitBtn.prop('disabled', false).html('<i class="icon-upload"></i> {{ __("dashboard.common.import") }}');
                progressBar.hide();
                progressBarInner.css('width', '0%').text('0%');
            }
        });
    </script>
@endsection

@section('page_styles')
    <style>
        .custom-file-label::after {
            content: "{{ __('dashboard.common.browse') }}";
        }

        .table code {
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 0.875em;
        }

        .progress {
            height: 25px;
        }

        .progress-bar {
            font-weight: bold;
            line-height: 25px;
        }
    </style>
@endsection
