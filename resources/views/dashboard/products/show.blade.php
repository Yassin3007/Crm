@extends('dashboard.layouts.master')

@section('content')
    <!-- Content section -->
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.product.view') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('products.index') }}">{{ __('dashboard.product.list') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.product.view') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic example section start -->
                <section id="basic-examples">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('dashboard.product.title') }} {{ __('dashboard.common.information') }}</h4>
                                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a href="{{ route('products.edit', $product->id) }}"
                                                   class="btn btn-sm btn-primary"><i
                                                        class="icon-pencil"></i> {{ __('dashboard.common.edit') }}</a>
                                            </li>
                                            <li><a href="{{ route('products.index') }}"
                                                   class="btn btn-sm btn-secondary"><i
                                                        class="icon-arrow-left4"></i> {{ __('dashboard.common.back') }}
                                                </a></li>
                                            <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body collapse in">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <tbody>
                                                        <tr>
                                                            <th width="200">{{ __('dashboard.common.id') }}</th>
                                                            <td>{{ $product->id }}</td>
                                                        </tr>

                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.name_en") }}
                                                                :</strong> {{ $product->name_en }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.name_ar") }}
                                                                :</strong> {{ $product->name_ar }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.desc_en") }}
                                                                :</strong> {{ $product->desc_en }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.desc_ar") }}
                                                                :</strong> {{ $product->desc_ar }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.code") }}
                                                                :</strong> {{ $product->code }}
                                                        </div>
{{--                                                        <div class="mb-3">--}}
{{--                                                            <strong>{{ __("dashboard.product.fields.image") }}--}}
{{--                                                                :</strong> {{ $product->image }}--}}
{{--                                                        </div>--}}
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.product.fields.price") }}
                                                                :</strong> {{ $product->price }}
                                                        </div>

                                                        <tr>
                                                            <th>{{ __('dashboard.common.created_at') }}</th>
                                                            <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('dashboard.common.updated_at') }}</th>
                                                            <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                  class="delete-form d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-md delete-btn">
                                                    <i class="icon-trash"></i> {{ __('dashboard.common.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic example section end -->
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script>
        $(document).ready(function () {
            $('.delete-btn').on('click', function (e) {
                e.preventDefault();

                // SweetAlert or custom confirmation
                if (confirm('{{ __("dashboard.product.delete_confirm") }}')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
