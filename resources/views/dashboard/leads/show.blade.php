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
                <!-- Basic example section start -->
                <section id="basic-examples">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('dashboard.lead.title') }} {{ __('dashboard.common.information') }}</h4>
                                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a href="{{ route('leads.edit', $lead->id) }}"
                                                   class="btn btn-sm btn-primary"><i
                                                        class="icon-pencil"></i> {{ __('dashboard.common.edit') }}</a>
                                            </li>
                                            <li><a href="{{ route('leads.index') }}" class="btn btn-sm btn-secondary"><i
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
                                                            <td>{{ $lead->id }}</td>
                                                        </tr>

                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.name") }}
                                                                :</strong> {{ $lead->name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.phone") }}
                                                                :</strong> {{ $lead->phone }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.whatsapp_number") }}
                                                                :</strong> {{ $lead->whatsapp_number }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.email") }}
                                                                :</strong> {{ $lead->email }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.national_id") }}
                                                                :</strong> {{ $lead->national_id }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.branch.title") }}
                                                                :</strong> {{ $lead->branch->name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.city.title") }}
                                                                :</strong> {{ $lead->city->name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.district.title") }}
                                                                :</strong> {{ $lead->district->name }}
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>{{ __("dashboard.lead.fields.location_link") }}
                                                                :</strong> <a style="text-decoration: underline" href="{{ $lead->location_link }}">{{ $lead->location_link }}</a>
                                                        </div>

                                                        <tr>
                                                            <th>{{ __('dashboard.common.created_at') }}</th>
                                                            <td>{{ $lead->created_at->format('Y-m-d H:i:s') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('dashboard.common.updated_at') }}</th>
                                                            <td>{{ $lead->updated_at->format('Y-m-d H:i:s') }}</td>
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
                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
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
                if (confirm('{{ __("dashboard.lead.delete_confirm") }}')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
