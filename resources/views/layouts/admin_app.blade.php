@extends('layouts.app')

@section('content')
  <div class="row g-0 mx-0 d-flex position-relative">
    @include('layouts.admin_sidebar')
    <div id="sidebarOverlay" class="sidebar-overlay"></div>

    <div class="col-5 main-content flex-grow-1" id="mainContent">
    @include('layouts.navbar')

    <div class="p-3 key-content">
      @yield('admin_content')
    </div>
    </div>
    <script>
    $(document).ready(function () {
      const $sidebar = $('#sidebarAdmin');
      const $overlay = $('#sidebarOverlay');

      function isDesktop() {
        return window.innerWidth > 992;
      }

      function closeMobileSidebar() {
        $sidebar.removeClass('sidebar-open');
        $overlay.removeClass('active');
      }

      $('#toggleSidebarBtn').on('click', function () {
        if (isDesktop()) {
          $sidebar.toggleClass('desktop-hidden');
        } else {
          $sidebar.toggleClass('sidebar-open');
          $overlay.toggleClass('active');
        }
      });

      $overlay.on('click', closeMobileSidebar);

      $(window).on('resize', function () {
        if (isDesktop()) {
          closeMobileSidebar();
        }
      });
    })
    </script>
  </div>
  </div>
@endsection
