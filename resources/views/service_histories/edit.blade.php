@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
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
            <form action="{{ route('serviceHistory.store')}}" method="POST">
               @csrf
               <input type="hidden" value="{{ $data->id }}" id="serviceHistoryId">
               <div class="mb-3">
                  <label for="service_date" class="form-label">Tanggal Periksa</label>
                  <input type="text" class="form-control" value="{{ $data->created_at->format('d-m-Y')}}" disabled>
               </div>
               <div class="mb-3">
                  <label for="patient_id" class="form-label">Nama Pasien</label>
                  <div class="input-group">
                     <select class="form-select js-patient-search" id="patient_id" name="patient_id"></select>
                     <a href="{{route('masterPatient.create')}}" class="btn btn-outline-primary mr-3"><i class='bx bx-plus'></i></a>
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
                     <a href="{{route('masterObat.create')}}" class="btn btn-outline-primary mr-3"><i class='bx bx-plus'></i></a>
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
$.ajax({
    type: 'GET',
    url: '{{ route("serviceHistory.edit", 2) }}' ,
}).then(function (response) {
   diagnosis.val(response.diagnosis);
   var patienOption = new Option(response.patient_name, response.id, true, true);
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