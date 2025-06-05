@extends('layouts.app')

@section('content')
   <div class="row g-0 mx-0 d-flex flex-nowrap">
      <!-- <div class="flex-shrink-0"> -->
      @include('layouts.siswa_sidebar')
      <!-- </div> -->

      <div class="col-5 main-content flex-grow-1">
        @include('layouts.navbar')

        <div class="p-3 key-content">
          @yield('siswa_content')
        </div>
      </div>
   </div>
   <script>
      $(document).ready(function () {
        $("#toggleSidebarBtn").on('click', function () {
          $("#sidebarSiswa").toggleClass('d-none');
        })
      })
   </script>
   @yield('custom-scripts')
@endsection