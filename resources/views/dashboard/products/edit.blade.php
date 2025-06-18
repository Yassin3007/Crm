@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.product.edit') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('dashboard.product.management') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.product.edit') }}
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
                                    <h4 class="card-title" id="basic-layout-tooltip">{{ __('dashboard.product.edit') }} {{ __('dashboard.product.title') }} #{{ $product->id }}</h4>
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
                                            <p>{{ __('dashboard.product.update_info') }}</p>
                                        </div>

                                        <form class="form" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="form-group">
            <label for="name_en">{{ __("dashboard.product.fields.name_en") }}</label>
            <input type="text" id="name_en" class="form-control @error('name_en') is-invalid @enderror"
                   name="name_en" value="{{ isset($product) ? $product->name_en : old('name_en') }}"
                   placeholder="{{ __("dashboard.product.fields.name_en") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.name_en") }}">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="name_ar">{{ __("dashboard.product.fields.name_ar") }}</label>
            <input type="text" id="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                   name="name_ar" value="{{ isset($product) ? $product->name_ar : old('name_ar') }}"
                   placeholder="{{ __("dashboard.product.fields.name_ar") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.name_ar") }}">
            @error('name_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="desc_en">{{ __("dashboard.product.fields.desc_en") }}</label>
            <input type="text" id="desc_en" class="form-control @error('desc_en') is-invalid @enderror"
                   name="desc_en" value="{{ isset($product) ? $product->desc_en : old('desc_en') }}"
                   placeholder="{{ __("dashboard.product.fields.desc_en") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.desc_en") }}">
            @error('desc_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="desc_ar">{{ __("dashboard.product.fields.desc_ar") }}</label>
            <input type="text" id="desc_ar" class="form-control @error('desc_ar') is-invalid @enderror"
                   name="desc_ar" value="{{ isset($product) ? $product->desc_ar : old('desc_ar') }}"
                   placeholder="{{ __("dashboard.product.fields.desc_ar") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.desc_ar") }}">
            @error('desc_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="code">{{ __("dashboard.product.fields.code") }}</label>
            <input type="text" id="code" class="form-control @error('code') is-invalid @enderror"
                   name="code" value="{{ isset($product) ? $product->code : old('code') }}"
                   placeholder="{{ __("dashboard.product.fields.code") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.code") }}">
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="image">{{ __("dashboard.product.fields.image") }}</label>
            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror"
                   name="image" value="{{ isset($product) ? $product->image : old('image') }}"
                   placeholder="{{ __("dashboard.product.fields.image") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.image") }}">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                <div class="form-group">
            <label for="price">{{ __("dashboard.product.fields.price") }}</label>
            <input type="text" id="price" class="form-control @error('price') is-invalid @enderror"
                   name="price" value="{{ isset($product) ? $product->price : old('price') }}"
                   placeholder="{{ __("dashboard.product.fields.price") }}" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{ __("dashboard.product.fields.price") }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
                                            </div>

                                            <div class="form-actions">
                                                <a href="{{ route('products.index') }}" class="btn btn-warning mr-1">
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
