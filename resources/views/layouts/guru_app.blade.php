@extends('layouts.app')

@section('content')
   <div class="row g-0 mx-0 d-flex">
      <div>
         @include('layouts.guru_sidebar')
      </div>

      <div class="col-md-10 col-lg-10 main-content">
         @include('layouts.navbar')

         <div class="p-3 key-content">
            @yield('guru_content')
         </div>
      </div>
   </div>
@endsection