<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Export PDF Riwayat Periksa</title>
   <style>
      .styled-table {
          border-collapse: collapse;
          width: 100%;
          margin: 25px 0;
          font-size: 12px;
          font-family: 'Arial', sans-serif;
          text-align: left;
      }
  
      /* Style the table header */
      .styled-table thead tr {
          background-color: #dadada;
          color: #ffffff;
          font-weight: bold;
      }
  
      /* Add some padding and border for each table cell */
      .styled-table th, .styled-table td {
          padding: 12px 10px;
          border: 1px solid #000000;
      }
      .title {
         font-family: 'Arial', sans-serif;
         text-align: center;
      }
      .title h1, .title h2, .title h3, .title h4, .title h5 {
         margin: 0px;
      }
  </style>
</head>
<body>
   <div class="title">
      <h2>Export PDF Riwayat Periksa</h2>
      <h5>per <span>{{date('d/m/Y')}}</span></h5>
   </div>
   <table class="styled-table">
      <thead>
         <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Tanggal Periksa</th>
            <th>Diagnosis</th>
            <th>Resep Obat</th>
         </tr>
      </thead>
      <tbody>
         @foreach ($serviceHistories as $key => $value)
         <tr>
            <td>{{$key + 1}}</td>
            <td>{{$value->patient_name}}</td>
            <td>{{$value->date_service}}</td>
            <td>{{$value->diagnosis}}</td>
            <td>{!! $value->drug_history !!}</td>
         </tr>
         @endforeach
      </tbody>
   </table>
</body>
</html>