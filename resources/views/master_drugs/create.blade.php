@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="col-md-12">
      <div class="card mb-4">
         <h5 class="card-header">Form Master Obat</h5>
         @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
               <ul>
                  @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                  @endforeach
               </ul>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif
         <div class="card-body">
            <form action="{{ route('masterObat.store')}}" method="POST">
               @csrf
               <div class="mb-3">
                  <label for="drug_name" class="form-label">Nama Obat</label>
                  <input type="text" class="form-control" id="drug_name" name="drug_name" value="{{ old('drug_name') }}" placeholder="">
               </div>
               <div class="mb-3">
                  <label for="remark" class="form-label">Keterangan</label>
                  <textarea class="form-control" id="remark" name="remark" rows="3">{{ old('remark') }}</textarea>
               </div>
               <div class="mb-3">
                  <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Simpan</button>
               </div>
            </form>
         </div>
      </div>
    </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
   
</script>
    
@endsection