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
            <div>
                  <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                  </ul>
            </div>
         @endif
         <div class="card-body">
            <form action="{{ route('serviceHistory.update', $data->id)}}" method="POST">
               @csrf
               @method('PUT')
               <input type="hidden" value="{{ $data->id }}" id="serviceHistoryId">
               <div class="mb-3">
                  <label for="service_date" class="form-label">Tanggal Periksa</label>
                  <input type="text" class="form-control" value="{{ $data->created_at->format('d-m-Y')}}" disabled>
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
   $(document).ready(function() {
      $('.js-patient-search').select2({
         
        ajax: {
            url: '{{ route("serviceHistory.patient") }}',  // Replace with your route
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.patient_name,  // The text property will be displayed in the dropdown
                            id: item.id       // The id property will be sent to the server
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 2, // Start searching after 2 characters
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

      // editable controll
var serviceHistoryId = $('#serviceHistoryId').val();

var diagnosis = $('#diagnosis');
var selectPatient = $('#patient_id');
var selectDrug = $('#medical_prescription');
var url = '{{ route("serviceHistory.edit", ":id") }}';
$.ajax({
    type: 'GET',
    url: url.replace(':id', serviceHistoryId),
}).then(function (response) {
   diagnosis.val(response.diagnosis);
   var patienOption = new Option(response.patient_name, response.patient_id, true, true);
   selectPatient.append(patienOption).trigger('change');

   response.drug_history.forEach(e => {
      var drugOption = new Option(e.drug_name, e.id, true, true);
      selectDrug.append(drugOption).trigger('change');
   });

   selectPatient.trigger({
      type: 'select2:select',
      params: {
         results: response
      }
   });
   selectDrug.trigger({
      type: 'select2:select',
      params: {
         results: response
      }
   });
});

   });
</script>
    
@endsection