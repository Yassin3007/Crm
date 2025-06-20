@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.district.edit') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('districts.index') }}">{{ __('dashboard.district.management') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.district.edit') }}
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
                                    <h4 class="card-title" id="basic-layout-tooltip">{{ __('dashboard.district.edit') }} {{ __('dashboard.district.title') }} #{{ $district->id }}</h4>
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
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <div class="card-text">
                                            <p>{{ __('dashboard.district.update_info') }}</p>
                                        </div>

                                        <form class="form" method="POST" action="{{ route('districts.update', $district->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="form-group">
            <label for="name_en">{{ __("dashboard.district.fields.name_en") }}</label>
            <input type="text" id="name_en" class="form-control @error('name_en') is-invalid @enderror"
                   name="name_en" value="{{ isset($district) ? $district->name_en : old('name_en') }}"
                   placeholder="{{ __("dashboard.district.fields.name_en") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.district.fields.name_en") }}">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="name_ar">{{ __("dashboard.district.fields.name_ar") }}</label>
            <input type="text" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                   name="name_ar" value="{{ isset($district) ? $district->name_ar : old('name_ar') }}"
                   placeholder="{{ __("dashboard.district.fields.name_ar") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.district.fields.name_ar") }}">
            @error('name_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="city_id">{{ __("dashboard.district.fields.city_id") }}</label>
            <select id="city_id" name="city_id" class="form-control @error('city_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.district.fields.city_id") }}">
                <option value="">{{ __("dashboard.common.select") }} {{ __("dashboard.district.fields.city_id") }}</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ isset($district) && $district->city_id == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="is_active">{{ __("dashboard.district.fields.is_active") }}</label>
            <select id="is_active" name="is_active" class="form-control @error('is_active') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.district.fields.is_active") }}">
                <option value="0" {{ isset($district) && !$district->is_active ? 'selected' : '' }}>{{ __("dashboard.common.no") }}</option>
                <option value="1" {{ isset($district) && $district->is_active ? 'selected' : '' }}>{{ __("dashboard.common.yes") }}</option>
            </select>
            @error('is_active')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                                            </div>

                                            <div class="form-actions">
                                                <a href="{{ route('districts.index') }}" class="btn btn-warning mr-1">
                                                    <i class="icon-cross2"></i> {{ __('dashboard.common.cancel') }}
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-check2"></i> {{ __('dashboard.common.update') }}
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
