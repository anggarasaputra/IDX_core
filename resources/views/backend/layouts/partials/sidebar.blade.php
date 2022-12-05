<!-- sidebar menu area start -->
@php
    $usr = Auth::guard('admin')->user();
@endphp
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">IDX</h2>
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="fa fa-dashboard"></i><span>dashboard</span></a>
                            <ul class="collapse {{ Route::is('admin.dashboard') ? 'in' : '' }}">
                                <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a
                                        href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('dashboard_user.view'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="fa fa-dashboard"></i><span>dashboard</span></a>
                            <ul class="collapse {{ Route::is('user.dashboard') ? 'in' : '' }}">
                                <li class="{{ Route::is('user.dashboard') ? 'active' : '' }}"><a
                                        href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('user_rooms.view'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-sign-in"></i><span>meeting
                                    rooms</span></a>
                            <ul class="collapse {{ Route::is('user.rooms') ? 'in' : '' }}">
                                <li class="{{ Route::is('user.rooms') ? 'active' : '' }}"><a
                                        href="{{ route('user.rooms') }}">Meeting Rooms</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('user_gallery.view'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i
                                    class="fa fa-tasks"></i><span>gallery</span></a>
                            <ul class="collapse {{ Route::is('user.gallery') || Route::is('user.gallery.order-index') ? 'in' : '' }}">
                                <li class="{{ Route::is('user.gallery') ? 'active' : '' }}"><a
                                        href="{{ route('user.gallery') }}">Gallery</a></li>
                                <li class="{{ Route::is('user.gallery.order-index') ? 'active' : '' }}"><a
                                        href="{{ route('user.gallery.order-index') }}">Order Gallery</a></li>
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('role.create') || $usr->can('role.view') || $usr->can('role.edit') || $usr->can('role.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                    Roles & Permissions
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                                @if ($usr->can('role.view'))
                                    <li
                                        class="{{ Route::is('admin.roles.index') || Route::is('admin.roles.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.roles.index') }}">All Roles</a>
                                    </li>
                                @endif
                                @if ($usr->can('role.create'))
                                    <li class="{{ Route::is('admin.roles.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.roles.create') }}">Create Role</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif


                    @if ($usr->can('admin.create') || $usr->can('admin.view') || $usr->can('admin.edit') || $usr->can('admin.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                                    Users
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">

                                @if ($usr->can('admin.view'))
                                    <li
                                        class="{{ Route::is('admin.admins.index') || Route::is('admin.admins.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.admins.index') }}">All Users</a>
                                    </li>
                                @endif

                                @if ($usr->can('admin.create'))
                                    <li class="{{ Route::is('admin.admins.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.admins.create') }}">Create User</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('hakaksions.create') ||
                        $usr->can('hakaksions.view') ||
                        $usr->can('hakaksions.edit') ||
                        $usr->can('hakaksions.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                                    Permission
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.hakaksions.create') || Route::is('admin.hakaksions.index') || Route::is('admin.hakaksions.edit') || Route::is('admin.hakaksions.show') ? 'in' : '' }}">

                                @if ($usr->can('admin.view'))
                                    <li
                                        class="{{ Route::is('admin.hakaksions.index') || Route::is('admin.hakaksions.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.hakaksions.index') }}">All Permission</a>
                                    </li>
                                @endif

                                @if ($usr->can('admin.create'))
                                    <li class="{{ Route::is('admin.hakaksions.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.hakaksions.create') }}">Create Permission</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('gallery.create') ||
                        $usr->can('gallery.view') ||
                        $usr->can('gallery.edit') ||
                        $usr->can('gallery.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                    Gallery
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.gallery.create') || Route::is('admin.gallery.index') || Route::is('admin.gallery.edit') || Route::is('admin.gallery.show') ? 'in' : '' }}">
                                @if ($usr->can('gallery.view'))
                                    <li
                                        class="{{ Route::is('admin.gallery.index') || Route::is('admin.gallery.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.gallery.index') }}">All Gallery</a>
                                    </li>
                                @endif
                                @if ($usr->can('gallery.create'))
                                    <li class="{{ Route::is('admin.gallery.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.gallery.create') }}">Create Gallery</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- Floor Section --}}
                    @if ($usr->can('floor.create') || $usr->can('floor.view') || $usr->can('floor.edit') || $usr->can('floor.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-building"></i><span>
                                    Floor
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.floor.create') || Route::is('admin.floor.index') || Route::is('admin.floor.edit') || Route::is('admin.floor.show') ? 'in' : '' }}">
                                @if ($usr->can('floor.view'))
                                    <li
                                        class="{{ Route::is('admin.floor.index') || Route::is('admin.floor.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.floor.index') }}">Floor List</a>
                                    </li>
                                @endif
                                @if ($usr->can('floor.create'))
                                    <li class="{{ Route::is('admin.floor.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.floor.create') }}">Create Floor</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- End Floor Section --}}

                    {{-- Rooms Section --}}
                    @if ($usr->can('rooms.create') || $usr->can('rooms.view') || $usr->can('rooms.edit') || $usr->can('rooms.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-sign-in"></i><span>
                                    Rooms
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.rooms.create') || Route::is('admin.rooms.index') || Route::is('admin.rooms.edit') || Route::is('admin.rooms.show') ? 'in' : '' }}">
                                @if ($usr->can('rooms.view'))
                                    <li
                                        class="{{ Route::is('admin.rooms.index') || Route::is('admin.rooms.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.rooms.index') }}">Rooms List</a>
                                    </li>
                                @endif
                                @if ($usr->can('rooms.create'))
                                    <li class="{{ Route::is('admin.rooms.create') ? 'active' : '' }}"><a
                                            href="{{ route('admin.rooms.create') }}">Create Rooms</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- End Rooms Section --}}

                    @if ($usr->can('activitylog.view') || $usr->can('activitylog.edit') || $usr->can('activitylog.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                    Activity Log
                                </span></a>
                            <ul
                                class="collapse {{ Route::is('admin.activitys.create') || Route::is('admin.activitys.index') || Route::is('admin.activitys.edit') || Route::is('admin.activitys.show') ? 'in' : '' }}">
                                @if ($usr->can('activitylog.view'))
                                    <li
                                        class="{{ Route::is('admin.activitys.index') || Route::is('admin.activitys.edit') ? 'active' : '' }}">
                                        <a href="{{ route('admin.activitys.index') }}">All activity</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if ($usr->can('order_gallery.view'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-book"></i><span>order
                                    gallery</span></a>
                            <ul class="collapse {{ Route::is('admin.order-gallery.index') ? 'in' : '' }}">
                                <li class="{{ Route::is('admin.order-gallery.index') ? 'active' : '' }}"><a
                                        href="{{ route('admin.order-gallery.index') }}">Order Gallery</a></li>
                            </ul>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->
