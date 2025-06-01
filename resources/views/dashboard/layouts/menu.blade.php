{{--<li class=" nav-item"><a href="index.html"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span><span class="tag tag tag-primary tag-pill float-xs-right mr-2">2</span></a>--}}
{{--    <ul class="menu-content">--}}
{{--        <li><a href="index.html" data-i18n="nav.dash.main" class="menu-item">Dashboard</a>--}}
{{--        </li>--}}
{{--        <li><a href="dashboard-2.html" data-i18n="nav.dash.main" class="menu-item">Dashboard 2</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</li>--}}
<li class=" nav-item"><a href="{{route('dashboard')}}"><i class="icon-copy"></i><span data-i18n="nav.changelog.main" class="menu-title">Dashboard</span></a>
</li>

@can('view_role')
<li class=" nav-item"><a href="{{ route('roles.index') }}"><i class="icon-list"></i><span data-i18n="nav.roles.main" class="menu-title">Roles</span></a>
</li>
@endcan

@can('view_permission')
<li class=" nav-item"><a href="{{ route('permissions.index') }}"><i class="icon-list"></i><span data-i18n="nav.permissions.main" class="menu-title">Permissions</span></a>
</li>
@endcan



@can('view_user')
<li class=" nav-item"><a href="{{ route('users.index') }}"><i class="icon-list"></i><span data-i18n="nav.users.main" class="menu-title">{{__('dashboard.user.title_plural')}}</span></a>
</li>
@endcan
@can('view_category')
<li class=" nav-item"><a href="{{ route('categories.index') }}"><i class="icon-list"></i><span data-i18n="nav.categories.main" class="menu-title">{{__('dashboard.category.title_plural')}}</span></a>
</li>
@endcan
@can('view_city')
<li class=" nav-item"><a href="{{ route('cities.index') }}"><i class="icon-list"></i><span data-i18n="nav.cities.main" class="menu-title">{{__('dashboard.city.title_plural')}}</span></a>
</li>
@endcan
@can('view_district')
<li class=" nav-item"><a href="{{ route('districts.index') }}"><i class="icon-list"></i><span data-i18n="nav.districts.main" class="menu-title">{{__('dashboard.district.title_plural')}}</span></a>
</li>
@endcan

@can('view_branch')
<li class=" nav-item"><a href="{{ route('branches.index') }}"><i class="icon-list"></i><span data-i18n="nav.branches.main" class="menu-title">{{__('dashboard.branch.title_plural')}}</span></a>
</li>
@endcan

