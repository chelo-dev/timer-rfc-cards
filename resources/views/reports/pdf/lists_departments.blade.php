@extends('layouts.reports.reports')
@section('title', 'Catalogo de departamentos')
@section('content')
<h5 class="mb-3 text-uppercase bg-dark p-3">Catalogo de departamentos</h5>
<table class="table table-sm mb-0">
    <thead class="text-white bg-kharma font-10">
        <tr>
            <th>NOMBRE</th>
            <th>DESCRIPCION</th>
            <th>FECHA DE CREACION</th>
            <th>FECHA DE ACTUALIZACION</th>
        </tr>
    </thead>
    <tbody style="font-size: 9px;">
        @foreach($departments as $department)
        <tr>
            <td>{{ $department->name }}</td>
            <td>{{ $department->description }}</td>
            <td>{{ $department->created_at }}</td>
            <td>{{ $department->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection