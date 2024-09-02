@extends('layouts/main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h1 class="card-title mb-2">Data Master Pasien</h1>
    <a href="{{ route('masterPatient.create') }}" class="btn btn-primary mb-3"><i class='bx bx-plus'></i>Tambah</a>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="6%">No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th width="11%">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection


@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('masterPatient.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'patient_name', name: 'patient_name'},
                {data: 'patient_address', name: 'patient_address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
    function confirmDelete() {
        return confirm('Are you sure you want to delete this data?');
    }   

 </script>
    
@endsection