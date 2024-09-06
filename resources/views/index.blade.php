@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="row">
      <div class="col-lg-12 col-md-4 order-1">
         <div class="row">
            <div class="col-lg-3 col-md-12 col-6 mb-4">
               <div class="card">
                  <a href="{{route('serviceHistory.create')}}">
                     <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                           <div class="avatar flex-shrink-0">
                              <img
                              src="frontend/assets/img/icons/unicons/health-services.png"
                              alt="health service"
                              class="rounded" />
                           </div>
                        </div>
                        <h3 class="card-title mb-2">Pelayanan</h3>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-4">
               <div class="card">
                  <a href="{{route('serviceHistory.index')}}">
                     <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                           <div class="avatar flex-shrink-0">
                              <img
                              src="frontend/assets/img/icons/unicons/history.png"
                              alt="health service"
                              class="rounded" />
                           </div>
                        </div>
                        <h3 class="card-title mb-2">Riwayat</h3>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-lg-3 col-md-12 col-6 mb-4">
               <div class="card">
                  <a href="{{route('report.index')}}">
                     <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                           <div class="avatar flex-shrink-0">
                              <img
                              src="frontend/assets/img/icons/unicons/report.png"
                              alt="health service"
                              class="rounded" />
                           </div>
                        </div>
                        <h3 class="card-title mb-2">Laporan</h3>
                     </div>
                  </a>
               </div>
            </div>
         
            
            
         </div>

      </div>
   </div>
</div>

@endsection