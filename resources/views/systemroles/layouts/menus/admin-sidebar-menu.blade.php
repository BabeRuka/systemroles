<ul class="list-unstyled">
    <!-- Dashboards -->
    <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ri-home-gear-line"></i>
            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Admin Menus">
                <span>SystemRoles Menus</span>
            </div>
        </a>

        <ul class="menu-sub">
             


            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-group-3-fill"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Roles">
                        <span>Roles</span>
                        <i class="ri-arrow-down-s-line toggle-icon"></i>
                    </div>
                </a>
                <ul class="menu-sub">
            
                    <li class="menu-item"><a class="nav-link active" href="{{ route('systemroles.admin.roles') }}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Roles</a></li>
                    <li class="menu-item"><a class="nav-link " href="{{  route('systemroles.admin.roles.permissions') }}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Permissions</a></li>
                    <li class="menu-item"><a class="nav-link " href="{{  route('systemroles.admin.roles.users') }}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Users</a></li> 
                    <li class="menu-item"><a class="nav-link " href="{{  route('systemroles.admin.roles.classes.index') }}"><span class="nav-icon"><span class="nav-icon-bullet"></span></span> Classes</a></li> 
                

                </ul>
            </li>

            
            <li class="menu-item">
                <a class="menu-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="menu-icon tf-icons ri-logout-box-r-line"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Modules">
                        <span>{{ __('Logout') }} </span>
                        
                    </div>

                </a>
            </li>

        </ul>
    </li>
    <li class="menu-item">
        <div class="float-left">
            <a class="menu-link menu-toggle" id="toggleSidebar"><i class="ri-collapse-horizontal-fill"></i></a>
        </div>
    </li>
</ul>
<form id="logout-form" action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">
    @csrf 
    
</form>