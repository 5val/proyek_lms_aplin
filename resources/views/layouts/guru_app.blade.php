@extends('layouts.app')

@section('content')
   <div class="row g-0 mx-0 d-flex">
      @include('layouts.guru_sidebar')

      <div class="col-5 main-content flex-grow-1">
        @include('layouts.navbar')
        @include('layouts.popup')

        <div class="p-3 key-content">
          @yield('guru_content')
        </div>
      </div>
   </div>
   <script>
      $(document).ready(function () {
        $("#toggleSidebarBtn").on('click', function () {
          $("#sidebarGuru").toggleClass('d-none');
        })
      })
   </script>
@endsection