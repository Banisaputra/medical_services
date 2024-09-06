@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-lg-12">
        <small class="text-light fw-medium">Laporan</small>
        <div class="demo-inline-spacing mt-3">
          <div class="list-group list-group-horizontal-md text-md-center" role="tablist">
            <a class="list-group-item list-group-item-action active" id="home-list-item" data-bs-toggle="list" href="#horizontal-home" aria-selected="false" role="tab" tabindex="-1">Master Obat</a>
            <a class="list-group-item list-group-item-action" id="profile-list-item" data-bs-toggle="list" href="#horizontal-profile" aria-selected="false" role="tab" tabindex="-1">Master Pasien</a>
            <a class="list-group-item list-group-item-action" id="messages-list-item" data-bs-toggle="list" href="#horizontal-messages" aria-selected="true" role="tab">History Periksa</a>
            
          </div>
          <div class="tab-content px-0 mt-0">
            <div class="tab-pane fade active show" id="horizontal-home" role="tabpanel" aria-labelledby="home-list-item">
                <a href="{{route('export.xlsx', 'masterDrug')}}" class="btn btn-success"><i class='bx bx-export' ></i> export Xlsx</a>
                <a href="{{route('export.pdf', 'masterDrug')}}" class="btn btn-danger" target="_blank"><i class='bx bxs-file-pdf' ></i> export PDF</a>
            </div>
            <div class="tab-pane fade" id="horizontal-profile" role="tabpanel" aria-labelledby="profile-list-item">
                <a href="{{route('export.xlsx', 'masterPatient')}}" class="btn btn-success"><i class='bx bx-export' ></i> export Xlsx</a>
                <a href="{{route('export.pdf', 'masterPatient')}}" class="btn btn-danger" target="_blank"><i class='bx bxs-file-pdf' ></i> export PDF</a>
            </div>
            <div class="tab-pane fade " id="horizontal-messages" role="tabpanel" aria-labelledby="messages-list-item">
                <a href="{{route('export.xlsx', 'serviceHistory')}}" class="btn btn-success"><i class='bx bx-export' ></i> export Xlsx</a>
                <a href="{{route('export.pdf', 'serviceHistory')}}" class="btn btn-danger" target="_blank"><i class='bx bxs-file-pdf' ></i> export PDF</a>
            </div>
          </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
    
 </script>
    
@endsection