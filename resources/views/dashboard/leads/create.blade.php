@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.lead.create') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('leads.index') }}">{{ __('dashboard.lead.management') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.lead.create') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"
                                        id="basic-layout-tooltip">{{ __('dashboard.lead.create_new') }}</h4>
                                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <div class="card-text">
                                            <p>{{ __('dashboard.lead.fill_required') }}</p>
                                        </div>

                                        <form class="form" method="POST" action="{{ route('leads.store') }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label for="name">{{ __("dashboard.lead.fields.name") }}</label>
                                                    <input type="text" id="name"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           name="name"
                                                           value="{{ isset($lead) ? $lead->name : old('name') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.name") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.name") }}">
                                                    @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">{{ __("dashboard.lead.fields.phone") }}</label>
                                                    <input type="text" id="phone"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           name="phone"
                                                           value="{{ isset($lead) ? $lead->phone : old('phone') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.phone") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.phone") }}">
                                                    @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="whatsapp_number">{{ __("dashboard.lead.fields.whatsapp_number") }}</label>
                                                    <input type="text" id="whatsapp_number"
                                                           class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                           name="whatsapp_number"
                                                           value="{{ isset($lead) ? $lead->whatsapp_number : old('whatsapp_number') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.whatsapp_number") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.whatsapp_number") }}">
                                                    @error('whatsapp_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">{{ __("dashboard.lead.fields.email") }}</label>
                                                    <input type="text" id="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="email"
                                                           value="{{ isset($lead) ? $lead->email : old('email') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.email") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.email") }}">
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="national_id">{{ __("dashboard.lead.fields.national_id") }}</label>
                                                    <input type="text" id="national_id"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="national_id"
                                                           value="{{ isset($lead) ? $lead->national_id : old('national_id') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.national_id") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.national_id") }}">
                                                    @error('national_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
{{--                                                <div class="form-group">--}}
{{--                                                    <label--}}
{{--                                                        for="national_id">{{ __("dashboard.lead.fields.national_id") }}</label>--}}
{{--                                                    <select id="national_id" name="national_id"--}}
{{--                                                            class="form-control @error('national_id') is-invalid @enderror"--}}
{{--                                                            data-toggle="tooltip" data-trigger="hover"--}}
{{--                                                            data-placement="top"--}}
{{--                                                            data-title="{{ __("dashboard.lead.fields.national_id") }}">--}}
{{--                                                        <option--}}
{{--                                                            value="">{{ __("dashboard.common.select") }} {{ __("dashboard.lead.fields.national_id") }}</option>--}}
{{--                                                        @foreach($nationals as $national)--}}
{{--                                                            <option--}}
{{--                                                                value="{{ $national->id }}" {{ isset($lead) && $lead->national_id == $national->id ? 'selected' : '' }}>--}}
{{--                                                                {{ $national->name }}--}}
{{--                                                            </option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
{{--                                                    @error('national_id')--}}
{{--                                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <label
                                                        for="branch_id">{{ __("dashboard.lead.fields.branch_id") }}</label>
                                                    <select id="branch_id" name="branch_id"
                                                            class="form-control @error('branch_id') is-invalid @enderror"
                                                            data-toggle="tooltip" data-trigger="hover"
                                                            data-placement="top"
                                                            data-title="{{ __("dashboard.lead.fields.branch_id") }}">
                                                        <option
                                                            value="">{{ __("dashboard.common.select") }} {{ __("dashboard.lead.fields.branch_id") }}</option>
                                                        @foreach($branches as $branch)
                                                            <option
                                                                value="{{ $branch->id }}" {{ isset($lead) && $lead->branch_id == $branch->id ? 'selected' : '' }}>
                                                                {{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('branch_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="source_id">{{ __("dashboard.source.title") }}</label>
                                                    <select id="source_id" name="source_id"
                                                            class="form-control @error('source_id') is-invalid @enderror"
                                                            data-toggle="tooltip" data-trigger="hover"
                                                            data-placement="top"
                                                            data-title="{{ __("dashboard.source.title") }}">
                                                        <option
                                                            value="">{{ __("dashboard.common.select") }} {{ __("dashboard.source.title") }}</option>
                                                        @foreach($sources as $source)
                                                            <option
                                                                value="{{ $source->id }}" {{ isset($lead) && $lead->source_id == $source->id ? 'selected' : '' }}>
                                                                {{ $source->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('source_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="district_id">{{ __("dashboard.lead.fields.district_id") }}</label>
                                                    <select id="district_id" name="district_id"
                                                            class="form-control @error('district_id') is-invalid @enderror"
                                                            data-toggle="tooltip" data-trigger="hover"
                                                            data-placement="top"
                                                            data-title="{{ __("dashboard.lead.fields.district_id") }}">
                                                        <option
                                                            value="">{{ __("dashboard.common.select") }} {{ __("dashboard.lead.fields.district_id") }}</option>
                                                        @foreach($districts as $district)
                                                            <option
                                                                value="{{ $district->id }}" {{ isset($lead) && $lead->district_id == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('district_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="location_link">{{ __("dashboard.lead.fields.location_link") }}</label>
                                                    <input type="text" id="location_link"
                                                           class="form-control @error('location_link') is-invalid @enderror"
                                                           name="location_link"
                                                           value="{{ isset($lead) ? $lead->location_link : old('location_link') }}"
                                                           placeholder="{{ __("dashboard.lead.fields.location_link") }}"
                                                           data-toggle="tooltip" data-trigger="hover"
                                                           data-placement="top"
                                                           data-title="{{ __("dashboard.lead.fields.location_link") }}">
                                                    @error('location_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <a href="{{ route('leads.index') }}" class="btn btn-warning mr-1">
                                                    <i class="icon-cross2"></i> {{ __('dashboard.common.cancel') }}
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-check2"></i> {{ __('dashboard.common.save') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
