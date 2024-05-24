<table>
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>DESCRIPCION</th>
            <th>FECHA DE CREACION</th>
            <th>FECHA DE ACTUALIZACION</th>
        </tr>
    </thead>
    <tbody>
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