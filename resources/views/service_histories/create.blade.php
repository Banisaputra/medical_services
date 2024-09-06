@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
   {{-- modalPatient --}}
   <div class="modal fade" id="modalPatient" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('masterPatient.store')}}" method="POST" id="addPatient">
               <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Tambah Pasien</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  @csrf 
                  <input type="hidden" value="1" name="is_service" id="is_service">
                  <div class="mb-3">
                     <label for="patient_name" class="form-label">Nama Pasien</label>
                     <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" placeholder="">
                  </div>
                  <div class="mb-3">
                     <label for="patient_address" class="form-label">Alamat</label>
                     <textarea class="form-control" id="patient_address" name="patient_address" rows="3">{{ old('patient_address') }}</textarea>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   {{-- end modalPatient --}}
   {{-- modalDrug --}}
   <div class="modal fade" id="modalDrug" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('masterObat.store')}}" method="POST" id="addDrug">
               <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Tambah Obat</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  @csrf
                  <input type="hidden" value="1" name="is_service" id="is_service">
                  <div class="mb-3">
                     <label for="drug_name" class="form-label">Nama Obat</label>
                     <input type="text" class="form-control" id="drug_name" name="drug_name" value="{{ old('drug_name') }}" placeholder="">
                  </div>
                  <div class="mb-3">
                     <label for="remark" class="form-label">Keterangan</label>
                     <textarea class="form-control" id="remark" name="remark" rows="3">{{ old('remark') }}</textarea>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   {{-- end modalDrug --}}
   <div class="col-md-12">
      <div class="card mb-4">
         <h5 class="card-header">Form Master Pasien</h5>
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
         @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
               {{ session('success') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
         @endif
         <div class="card-body">
            <form action="{{ route('serviceHistory.store')}}" method="POST">
               @csrf
               <div class="mb-3">
                  <label for="service_date" class="form-label">Tanggal Periksa</label>
                  <input type="text" class="form-control" value="{{ Date('d-m-Y')}}" disabled>
               </div>
               <div class="mb-3">
                  <label for="patient_id" class="form-label">Nama Pasien</label>
                  <div class="input-group">
                     <select class="form-select js-patient-search" id="patient_id" name="patient_id"></select>
                     {{-- <a href="{{route('masterPatient.create')}}" class="btn btn-outline-primary mr-3"><i class='bx bx-plus'></i></a> --}}
                     <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPatient"><i class='bx bx-plus'></i></button>
                  </div>
               </div>
               <div class="mb-3">
                  <label for="diagnosis" class="form-label">Diagnosis</label>
                  <input type="text" class="form-control" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}" placeholder="">
               </div>
               <div class="mb-3">
                  <label for="medical_prescription" class="form-label">Resep Obat</label>
                  <div class="input-group">
                     <select class="form-select js-drug-search" id="medical_prescription" name="medical_prescription[]" multiple="multiple"></select>
                     {{-- <a href="{{route('masterObat.create')}}" class="btn btn-outline-primary mr-3"><i class='bx bx-plus'></i></a> --}}
                     <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalDrug"><i class='bx bx-plus'></i></button>
                  </div>
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
   $(document).ready(function() {
      $('.js-patient-search').select2({
        ajax: {
            url: '{{ route("serviceHistory.patient") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.patient_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: 'Select patient',
        allowClear: true
      });
      
      $('.js-drug-search').select2({
         
        ajax: {
            url: '{{ route("serviceHistory.drug") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.drug_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        placeholder: 'Select drug',
        allowClear: true,
        multiple: true
      });

      // clear form modalPatient
      $('#modalPatient, #modalDrug').on('hidden.bs.modal', function (e) {
         $(this).find('form').trigger('reset');
      })
       
   });
</script>
    
@endsection