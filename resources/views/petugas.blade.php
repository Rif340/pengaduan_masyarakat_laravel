<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/home.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Petugas</title>
</head>

<body>
  @include('layouts.sidebar-petugas')

  <div class="container" style="margin-top: 6rem;">
  <h1 class="text-center">Data Petugas</h1>
    <table style="margin-top: 2rem;" class="table">
      <thead>
        <tr>
          <th scope="col" class="table-warning">nik</th>
          <th scope="col" class="table-warning">Nama</th>
          <th scope="col" class="table-warning">username</th>
          <th scope="col" class="table-warning">telepon</th>
          <th scope="col" class="table-warning">level</th>

        </tr>
      </thead>
      <tbody>
        @foreach($petugas as $petugas)
        <tr>
          <th scope="row" class="table-secondary">{{$petugas->id}}</th>
          <td class="table-secondary">{{$petugas->nama_petugas}}</td>
          <td class="table-secondary">{{$petugas->username}}</td>
          <td class="table-secondary">{{$petugas->telp}}</td>
          <td class="table-secondary">{{$petugas->level}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>