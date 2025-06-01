@extends('dashboard.layouts.master')

@section('content')
    <!-- Content section -->
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.branch.view') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('branches.index') }}">{{ __('dashboard.branch.list') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('dashboard.branch.view') }}</li>
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
                                    <h4 class="card-title">{{ __('dashboard.branch.title') }} {{ __('dashboard.common.information') }}</h4>
                                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-primary"><i class="icon-pencil"></i> {{ __('dashboard.common.edit') }}</a></li>
                                            <li><a href="{{ route('branches.index') }}" class="btn btn-sm btn-secondary"><i class="icon-arrow-left4"></i> {{ __('dashboard.common.back') }}</a></li>
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
                                                            <td>{{ $branch->id }}</td>
                                                        </tr>

                                                        <div class="mb-3">
        <strong>{{ __("dashboard.branch.fields.name_en") }}:</strong> {{ $branch->name_en }}
    </div>
                <div class="mb-3">
        <strong>{{ __("dashboard.branch.fields.name_ar") }}:</strong> {{ $branch->name_ar }}
    </div>
                <div class="mb-3">
        <strong>{{ __("dashboard.branch.fields.city_id") }}:</strong> {{ $branch->city_id }}
    </div>
                <div class="mb-3">
        <strong>{{ __("dashboard.branch.fields.is_active") }}:</strong> {{ $branch->is_active }}
    </div>

                                                        <tr>
                                                            <th>{{ __('dashboard.common.created_at') }}</th>
                                                            <td>{{ $branch->created_at->format('Y-m-d H:i:s') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('dashboard.common.updated_at') }}</th>
                                                            <td>{{ $branch->updated_at->format('Y-m-d H:i:s') }}</td>
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
                                            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="delete-form d-inline-block">
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
        $(document).ready(function() {
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                // SweetAlert or custom confirmation
                if (confirm('{{ __("dashboard.branch.delete_confirm") }}')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
