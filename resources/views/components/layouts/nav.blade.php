    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
            @foreach ($items as $item)
              <li class="nav-item">
                <a href="{{ route($item['url']) }}" class="nav-link">
                  <i class="{{ $item['icon'] }}"></i>
                  <p>{{ $item['title'] }}
                    @if($item['padge'] ?? false)
                        <span class="right badge badge-danger">{{ $item['padge'] }}</span>
                    @endif
                  </p>
                </a>
              </li>
            @endforeach
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
