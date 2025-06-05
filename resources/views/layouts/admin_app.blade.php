@extends('layouts.app')

@section('content')
  <div class="row g-0 mx-0 d-flex">
    @include('layouts.admin_sidebar')

    <div class="col-5 main-content flex-grow-1">
    @include('layouts.navbar')

    <div class="p-3 key-content">
      @yield('admin_content')
    </div>
    </div>
    <script>
    $(document).ready(function () {
      $("#toggleSidebarBtn").on('click', function () {
      $("#sidebarAdmin").toggleClass('d-none');
      })
    })
    </script>
  </div>
  </div>
@endsection