@extends('dashboard.layouts.master')

@section('content')
    <div class="app-content content container-fluid">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-xs-12 mb-1">
                    <h2 class="content-header-title">{{ __('dashboard.lead.management') }}</h2>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-xs-12">
                    <div class="breadcrumb-wrapper col-xs-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('dashboard') }}">{{ __('dashboard.common.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('dashboard.lead.title') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Filters Card -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('dashboard.common.filters') }}</h4>
                                <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body collapse in">
                                <div class="card-block">
                                    <form method="GET" action="{{ route('leads.index') }}">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="name">{{ __('dashboard.lead.fields.name') }}</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           value="{{ request('name') }}" placeholder="{{ __('dashboard.lead.fields.name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="phone">{{ __('dashboard.lead.fields.phone') }}</label>
                                                    <input type="text" class="form-control" id="phone" name="phone"
                                                           value="{{ request('phone') }}" placeholder="{{ __('dashboard.lead.fields.phone') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="email">{{ __('dashboard.lead.fields.email') }}</label>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                           value="{{ request('email') }}" placeholder="{{ __('dashboard.lead.fields.email') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="city_id">{{ __('dashboard.city.title') }}</label>
                                                    <select class="form-control" id="city_id" name="city_id">
                                                        <option value="">{{ __('dashboard.common.select') }} {{ __('dashboard.city.title') }}</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="branch_id">{{ __('dashboard.branch.title') }}</label>
                                                    <select class="form-control" id="branch_id" name="branch_id">
                                                        <option value="">{{ __('dashboard.common.select') }} {{ __('dashboard.branch.title') }}</option>
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                                {{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="district_id">{{ __('dashboard.district.title') }}</label>
                                                    <select class="form-control" id="district_id" name="district_id">
                                                        <option value="">{{ __('dashboard.common.select') }} {{ __('dashboard.district.title') }}</option>
                                                        @foreach($districts as $district)
                                                            <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                                                {{ $district->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="date_from">{{ __('dashboard.common.date_from') }}</label>
                                                    <input type="date" class="form-control" id="date_from" name="date_from"
                                                           value="{{ request('date_from') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                                <div class="form-group">
                                                    <label for="date_to">{{ __('dashboard.common.date_to') }}</label>
                                                    <input type="date" class="form-control" id="date_to" name="date_to"
                                                           value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="icon-search4"></i> {{ __('dashboard.common.filter') }}
                                                </button>
                                                <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                                    <i class="icon-refresh2"></i> {{ __('dashboard.common.reset') }}
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table head options start -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('dashboard.lead.list') }}</h4>
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
                                    @can('create_lead')
                                        <a href="{{ route('leads.create') }}" class="btn btn-success mb-1">
                                            <i class="icon-plus2"></i> {{ __('dashboard.lead.add_new') }}
                                        </a>
                                    @endcan

                                    @if(!empty(array_filter($filters ?? [])))
                                        <div class="alert alert-info">
                                            <strong>{{ __('dashboard.common.active_filters') }}:</strong>
                                            @foreach($filters as $key => $value)
                                                @if(!empty($value))
                                                    <span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-inverse">
                                        <tr>
                                            <th>{{ __('dashboard.common.number') }}</th>
                                            <th>{{ __("dashboard.lead.fields.name") }}</th>
                                            <th>{{ __("dashboard.lead.fields.phone") }}</th>
                                            <th>{{ __("dashboard.lead.fields.whatsapp_number") }}</th>
                                            <th>{{ __("dashboard.lead.fields.email") }}</th>
                                            <th>{{ __("dashboard.lead.fields.national_id") }}</th>
                                            <th>{{ __("dashboard.branch.title") }}</th>
                                            <th>{{ __("dashboard.city.title") }}</th>
                                            <th>{{ __("dashboard.district.title") }}</th>
                                            <th>{{ __("dashboard.lead.fields.location_link") }}</th>
                                            <th>{{ __('dashboard.common.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($leads as $lead)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration + ($leads->currentPage() - 1) * $leads->perPage() }}</th>
                                                <td>{{ $lead->name }}</td>
                                                <td>{{ $lead->phone }}</td>
                                                <td>{{ $lead->whatsapp_number }}</td>
                                                <td>{{ $lead->email }}</td>
                                                <td>{{ $lead->national_id }}</td>
                                                <td>{{ $lead->branch->name ?? '-' }}</td>
                                                <td>{{ $lead->city->name ?? '-' }}</td>
                                                <td>{{ $lead->district->name ?? '-' }}</td>
                                                <td>
                                                    @if($lead->location_link)
                                                        <a target="_blank" style="text-decoration: underline" href="{{ $lead->location_link }}">
                                                            {{ __("dashboard.common.link") }}
                                                        </a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('view_lead')
                                                        <a href="{{ route('leads.show', $lead->id) }}"
                                                           class="btn btn-info btn-sm">
                                                            <i class="icon-eye6"></i> {{ __('dashboard.common.view') }}
                                                        </a>
                                                    @endcan

                                                    @can('edit_lead')
                                                        <a href="{{ route('leads.edit', $lead->id) }}"
                                                           class="btn btn-warning btn-sm">
                                                            <i class="icon-pencil3"></i> {{ __('dashboard.common.edit') }}
                                                        </a>
                                                    @endcan

                                                    @can('delete_lead')
                                                        <form action="{{ route('leads.destroy', $lead->id) }}"
                                                              method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('{{ __('dashboard.lead.delete_confirm') }}');">
                                                                <i class="icon-trash4"></i> {{ __('dashboard.common.delete') }}
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">{{ __('dashboard.lead.no_records') }}</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    {{ $leads->appends(request()->query())->links() }}
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
