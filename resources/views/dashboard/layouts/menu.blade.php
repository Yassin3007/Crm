{{-- Dashboard --}}
<li class=" nav-item"><a href="{{route('dashboard')}}"><i class="icon-home3"></i><span data-i18n="nav.changelog.main" class="menu-title">{{__('dashboard.common.dashboard')}}</span></a>
</li>

{{-- User Management Section --}}
@can('view_user')
    <li class=" nav-item"><a href="{{ route('users.index') }}"><i class="icon-user"></i><span data-i18n="nav.users.main" class="menu-title">{{__('dashboard.user.title_plural')}}</span></a>
    </li>
@endcan

@can('view_role')
    <li class=" nav-item"><a href="{{ route('roles.index') }}"><i class="icon-badge"></i><span data-i18n="nav.roles.main" class="menu-title">{{__('dashboard.common.roles')}}</span></a>
    </li>
@endcan

@can('view_permission')
    <li class=" nav-item"><a href="{{ route('permissions.index') }}"><i class="icon-key"></i><span data-i18n="nav.permissions.main" class="menu-title">{{__('dashboard.common.permissions')}}</span></a>
    </li>
@endcan

{{-- Content Management Section --}}
@can('view_category')
    <li class=" nav-item"><a href="{{ route('categories.index') }}"><i class="icon-folder"></i><span data-i18n="nav.categories.main" class="menu-title">{{__('dashboard.category.title_plural')}}</span></a>
    </li>
@endcan

{{-- Location Management Section --}}
@can('view_city')
    <li class=" nav-item"><a href="{{ route('cities.index') }}"><i class="icon-map-marker"></i><span data-i18n="nav.cities.main" class="menu-title">{{__('dashboard.city.title_plural')}}</span></a>
    </li>
@endcan

@can('view_district')
    <li class=" nav-item"><a href="{{ route('districts.index') }}"><i class="icon-map-marker"></i><span data-i18n="nav.districts.main" class="menu-title">{{__('dashboard.district.title_plural')}}</span></a>
    </li>
@endcan

{{-- Business Operations Section --}}
@can('view_branch')
    <li class=" nav-item"><a href="{{ route('branches.index') }}"><i class="icon-address-book"></i><span data-i18n="nav.branches.main" class="menu-title">{{__('dashboard.branch.title_plural')}}</span></a>
    </li>
@endcan

@can('view_lead')
    <li class=" nav-item"><a href="{{ route('leads.index') }}"><i class="icon-list"></i><span data-i18n="nav.leads.main" class="menu-title">{{__('dashboard.lead.title_plural')}}</span></a>
    </li>
@endcan

@can('view_source')
<li class=" nav-item"><a href="{{ route('sources.index') }}"><i class="icon-folder"></i><span data-i18n="nav.sources.main" class="menu-title">{{__('dashboard.source.title_plural')}}</span></a>
</li>
@endcan

@can('view_category')
<li class=" nav-item"><a href="{{ route('categories.index') }}"><i class="icon-list"></i><span data-i18n="nav.categories.main" class="menu-title">{{__('dashboard.category.title_plural')}}</span></a>
</li>
@endcan
@can('view_product')
<li class=" nav-item"><a href="{{ route('products.index') }}"><i class="icon-list"></i><span data-i18n="nav.products.main" class="menu-title">{{__('dashboard.product.title_plural')}}</span></a>
</li>
@endcan