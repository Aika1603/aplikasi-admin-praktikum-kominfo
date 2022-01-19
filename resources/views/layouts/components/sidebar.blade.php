<!-- Main -->
<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

<li class="nav-item">
    <a href="{{ route('dashboard.index') }}" class="nav-link  {{ @$menu == 'Dashboard' ? 'active' : '' }} ">
        <i class="icon-home4"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Features</div> <i class="icon-menu" title="Main"></i></li>

<li class="nav-item">
    <a href="{{ route('wifi_locations.index') }}" class="nav-link  {{ @$menu == 'Wifi Locations' ? 'active' : '' }} ">
        <i class="icon-location4"></i>
        <span>Wifi Locations</span>
    </a>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main Master </div> <i class="icon-menu" title="Main"></i></li>

<li class="nav-item nav-item-submenu {{ @$menu == 'Master Data' ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="icon-database"></i>
        <span>Master Data </span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
        <li class="nav-item"><a href="{{ route('kecamatans.index') }}" class="nav-link {{ @$submenu == 'Kecamatan' ? 'active' : '' }}">Kecamatan</a></li>
        <li class="nav-item"><a href="{{ route('desas.index') }}" class="nav-link {{ @$submenu == 'Desa' ? 'active' : '' }}">Desa</a></li>
    </ul>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Administration</div> <i class="icon-menu" title="Main"></i></li>
<li class="nav-item nav-item-submenu {{ @$menu == 'Users Management' ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="icon-users"></i>
        <span>Users Management </span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
        <li class="nav-item"><a href="{{ route('users.index') }}" class="nav-link {{ @$submenu == 'Users List' ? 'active' : '' }}">Users List</a></li>
        <li class="nav-item"><a href="{{ route('roles.index') }}" class="nav-link {{ @$submenu == 'Roles List' ? 'active' : '' }}">Roles List</a></li>
        <li class="nav-item"><a href="{{ route('permissions.index') }}" class="nav-link {{ @$submenu == 'Permissions' ? 'active' : '' }}">Permissions</a></li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('menus.index') }}" class="nav-link  {{ @$menu == 'Menus' ? 'active' : '' }} ">
        <i class="icon-grid4"></i>
        <span>Menus</span>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('actions.index') }}" class="nav-link  {{ @$menu == 'Action' ? 'active' : '' }} ">
        <i class="icon-select2"></i>
        <span>Actions</span>
    </a>
</li>

