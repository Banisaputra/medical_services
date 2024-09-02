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
            <form action="{{ route('masterObat.update', $item->id)}}" method="POST">
               @csrf
               @method('PUT')
               <div class="mb-3">
                  <label for="drug_name" class="form-label">Nama Obat</label>
                  <input type="text" class="form-control" id="drug_name" name="drug_name" value="{{ old('drug_name', $item->drug_name) }}" placeholder="">
               </div>
               <div class="mb-3">
                  <label for="remark" class="form-label">Keterangan</label>
                  <textarea class="form-control" id="remark" name="remark" rows="3">{{ old('remark', $item->remark) }}</textarea>
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