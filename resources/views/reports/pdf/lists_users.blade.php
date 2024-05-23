@extends('layouts.reports.reports')
@section('title', 'Catalogo de usuarios')
@section('content')
<h5 class="mb-3 text-uppercase bg-dark p-3">Catalogo de usuarios</h5>
<table class="table table-sm mb-0">
    <thead class="text-white bg-kharma font-10">
        <tr>
            <th>NOMBRE</th>
            <th>EMAIL</th>
            <th>DEPARTAMENTO</th>
            <th>POSISION</th>
            <th>ESTATUS</th>
            <th>TELEFONO</th>
            <th>COMENTARIOS</th>
            <th>ULTIMO ACCESO</th>
            <th>ROL</th>
            <th>FECHA DE CREACION</th>
            <th>FECHA DE ACTUALIZACION</th>
        </tr>
    </thead>
    <tbody style="font-size: 9px;">
        @foreach($users as $user)
        <tr>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user['email'] }}</td>
            <td>{{ $user['department'] ?? 'N/A' }}</td>
            <td>{{ $user['position'] ?? 'N/A' }}</td>
            <td>{{ $user['is_active'] ? 'Activo' : 'Desactivado' }}</td>
            <td>{{ $user['phone'] }}</td>
            <td>{{ $user['notes'] }}</td>
            <td>{{ $user['last_login'] }}</td>
            <td>{{ $user['role'] }}</td>
            <td>{{ $user['created_at'] }}</td>
            <td>{{ $user['updated_at'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection