@extends('layouts.app')

@section('content')
   <div class="row g-0 mx-0 d-flex">
      @include('layouts.guru_sidebar')

      <div class="col-5 main-content flex-grow-1 d-flex flex-column">
        <div class="sticky-top">
          @include('layouts.navbar')
        </div>
        @include('layouts.popup')

        <div class="p-3 key-content flex-grow-1">
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
   @yield('custom-scripts')
@endsection
