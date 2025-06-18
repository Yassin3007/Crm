@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.product.management') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.product.title') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Table head options start -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('dashboard.product.list') }}</h4>
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
                                <div class="card-block card-dashboard">
                                    @can('create_product')
                                        <a href="{{ route('products.create') }}" class="btn btn-primary mb-1">
                                            <i class="icon-plus2"></i> {{ __('dashboard.product.add_new') }}
                                        </a>
                                    @endcan
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-inverse">
                                        <tr>
                                            <th>{{ __('dashboard.common.number') }}</th>
                                            <th>{{ __("dashboard.product.fields.name_en") }}</th>
                                            <th>{{ __("dashboard.product.fields.name_ar") }}</th>
                                            <th>{{ __("dashboard.product.fields.desc_en") }}</th>
                                            <th>{{ __("dashboard.product.fields.desc_ar") }}</th>
                                            <th>{{ __("dashboard.product.fields.code") }}</th>
                                            <th>{{ __("dashboard.product.fields.image") }}</th>
                                            <th>{{ __("dashboard.product.fields.price") }}</th>
                                            <th>{{ __('dashboard.common.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $product->name_en }}</td>
                                                <td>{{ $product->name_ar }}</td>
                                                <td>{{ $product->desc_en }}</td>
                                                <td>{{ $product->desc_ar }}</td>
                                                <td>{{ $product->code }}</td>
                                                <td> <img width="70px" src="{{ $product->image_url }}"></td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    @can('view_product')
                                                        <a href="{{ route('products.show', $product->id) }}"
                                                           class="btn btn-info btn-sm">
                                                            <i class="icon-eye6"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit_product')
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                           class="btn btn-warning btn-sm">
                                                            <i class="icon-pencil3"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete_product')
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                              method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('{{ __('dashboard.product.delete_confirm') }}');">
                                                                <i class="icon-trash4"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ 2 + count(Schema::getColumnListing('products')) }}"
                                                    class="text-center">{{ __('dashboard.product.no_records') }}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    {{$products->links()}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table head options end -->
            </div>
        </div>
    </div>
@endsection
