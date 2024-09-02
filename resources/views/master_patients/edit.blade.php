@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   <div class="col-md-12">
      <div class="card mb-4">
         <h5 class="card-header">Form Master Obat</h5>
         @if ($errors->any())
            <div>
                  <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                  </ul>
            </div>
         @endif
         <div class="card-body">
            <form action="{{ route('masterPatient.update', $item->id)}}" method="POST">
               @csrf
               @method('PUT')
               <div class="mb-3">
                  <label for="patient_name" class="form-label">Nama Pasien</label>
                  <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name', $item->patient_name) }}" placeholder="">
               </div>
               <div class="mb-3">
                  <label for="patient_address" class="form-label">Alamat</label>
                  <textarea class="form-control" id="patient_address" name="patient_address" rows="3">{{ old('patient_address', $item->patient_address) }}</textarea>
               </div>
               <div class="mb-3">
                  <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Update</button>
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