<!-- Main -->
<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

<li class="nav-item">
    <a href="{{ route('dashboard.index') }}" class="nav-link  {{ @$menu == 'Dashboard' ? 'active' : '' }} ">
        <i class="icon-home4"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Features</div> <i class="icon-menu" title="Main"></i></li>
<li class="nav-item nav-item-submenu {{ @$menu == 'Menu Level 1' ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="icon-files-empty"></i>
        <span>Menu Level 1 </span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
        <li class="nav-item nav-item-submenu {{ @$submenu == 'Menu Level 2' ? 'nav-item-expanded nav-item-open' : '' }}">
            <a href="#" class="nav-link">Menu Level 2</a>
            <ul class="nav nav-group-sub">
                <li class="nav-item"><a href="{{ route('dashboard.index') }}" class="nav-link {{ @$subsubmenu == 'Menu Level 3' ? 'active' : '' }}">Menu Level 3</a></li>
            </ul>
        </li>
     </ul>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main Master </div> <i class="icon-menu" title="Main"></i></li>

<li class="nav-item nav-item-submenu {{ @$menu == 'Master Data' ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="icon-database"></i>
        <span>Master Data </span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
        <li class="nav-item"><a href="{{ route('perusahaans.index') }}" class="nav-link {{ @$submenu == 'Perusahaan' ? 'active' : '' }}">Perusahaan</a></li>
    </ul>
</li>

<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Settings</div> <i class="icon-menu" title="Main"></i></li>
<li class="nav-item nav-item-submenu {{ @$menu == 'System Settings' ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="icon-cog2"></i>
        <span>System Settings </span>
    </a>
    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
        <li class="nav-item"><a href="{{ route('dashboard.index') }}" class="nav-link {{ @$submenu == 'System Settings' ? 'active' : '' }}">System Settings</a></li>
        <li class="nav-item"><a href="{{ route('dashboard.index') }}" class="nav-link {{ @$submenu == 'Logs System' ? 'active' : '' }}">Logs System</a></li>
        <li class="nav-item"><a href="{{ route('dashboard.index') }}" class="nav-link {{ @$submenu == 'Preferensi' ? 'active' : '' }}">Preferensi</a></li>
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

