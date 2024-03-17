@php
    $segment1 = request()->segment(2);
    $segment2 = request()->segment(3);
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('constants.APP_NAME') }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor" fill-opacity="0.6"/>
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor" fill-opacity="0.38"/>
            </svg>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ $segment1 == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        @canany(['member_access', 'role_access', 'permission_access','security_access'])
            <li
                class="menu-item {{ $segment1 == 'members' || $segment1 == 'roles' || $segment1 == 'security' || $segment1 == 'permissions' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-account-cog-outline"></i>
                    <div data-i18n="Administrator">Administrator</div>

                </a>
                <ul class="menu-sub">
                    @can('security_access')
                        <li class="menu-item {{ ($segment1 == 'security') ? 'active' : '' }}">
                            <a href="{{route('admin.security.index')}}" class="menu-link">
                                <div data-i18n="Security">Security</div>
                            </a>
                        </li>
                    @endcan
                    @can('member_access')
                        <li class="menu-item {{ $segment1 == 'members' ? 'active' : '' }}">
                            <a href="{{ route('admin.members.index') }}" class="menu-link">
                                <div data-i18n="Members">Members</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="menu-item {{ $segment1 == 'roles' ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Roles">Roles</div>
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="menu-item {{ $segment1 == 'permissions' ? 'active' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Permissions">Permissions</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['user_access', 'user_activity_access'])
            <li class="menu-item {{ $segment1 == 'users' || $segment1 == 'users' && $segment2 == 'logs' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                    <div data-i18n="User Management">User Management</div>

                </a>
                <ul class="menu-sub">
                    @can('user_access')
                        <li
                            class="menu-item {{ ($segment1 == 'users' && $segment2 == '' or $segment1 == 'users' && $segment2 == 'view-detail') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Users">Users</div>
                            </a>
                        </li>
                    @endcan
                    <li
                        class="menu-item {{ ($segment1 == 'users' && $segment2 == 'tracking') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.tracking') }}" class="menu-link">
                            <div data-i18n="Tracking">Tracking</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcanany
        <li class="menu-item {{ $segment1 == 'image-compress' ? 'active' : '' }}">
            <a href="{{ route('admin.image-compression.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-image-album"></i>
                <div data-i18n="Image Compression">Image Compression</div>
            </a>
        </li>
        @canany(['setting_type_access', 'setting_access'])
            <li class="menu-item {{ $segment1 == 'settings' || $segment1 == 'types' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-cog"></i>
                    <div data-i18n="Settings">Settings</div>
                </a>
                <ul class="menu-sub">
                    @can('setting_type_access')
                        <li class="menu-item {{ $segment1 == 'settings' && $segment2 == 'types' ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.types') }}" class="menu-link">
                                <div data-i18n="Settings Types">Settings Types</div>
                            </a>
                        </li>
                    @endcan
                    @can('setting_access')
                        <li class="menu-item {{ $segment1 == 'settings' && $segment2 == null ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('admin.settings.index') }}">
                                <div data-i18n="Settings">Settings</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
</aside>
