<table>
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>EMAIL</th>
            <th>DEPARTAMENTO</th>
            <th>POSISION</th>
            <th>ESTATUS</th>
            <th>TELEFONO</th>
            <th>COMENTARIOS</th>
            <th>ULTIMA FECHA DE ACCESO</th>
            <th>ROL</th>
            <th>FECHA DE CREACION</th>
            <th>FECHA DE ACTUALIZACION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user['email'] }}</td>
            <td>{{ $user['department'] }}</td>
            <td>{{ $user['position'] }}</td>
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