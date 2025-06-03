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
                                <h4 class="card-title">{{ __('dashboard.lead.import') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-block">
                                    <div class="alert alert-info">
                                        <h5>{{ __('dashboard.common.import_instructions') }}:</h5>
                                        <ul class="mb-0">
                                            <li>{{ __('dashboard.common.download_template_first') }}</li>
                                            <li>{{ __('dashboard.common.fill_data_exactly') }}</li>
                                            <li>{{ __('dashboard.common.phone_must_be_unique') }}</li>
                                            <li>{{ __('dashboard.common.branch_city_district_must_exist') }}</li>
                                        </ul>
                                    </div>

                                    <div class="text-center mb-2">
                                        <a href="{{ route('leads.template.download') }}" class="btn btn-secondary">
                                            <i class="icon-file-excel"></i> {{ __('dashboard.common.download_template') }}
                                        </a>
                                    </div>

                                    <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">{{ __('dashboard.common.select_file') }}</label>
                                            <input type="file"
                                                   class="form-control @error('file') is-invalid @enderror"
                                                   id="file"
                                                   name="file"
                                                   accept=".xlsx,.xls,.csv"
                                                   required>
                                            @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-actions text-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icon-upload4"></i> {{ __('dashboard.common.import') }}
                                            </button>
                                            <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                                <i class="icon-arrow-left"></i> {{ __('dashboard.common.back') }}
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
