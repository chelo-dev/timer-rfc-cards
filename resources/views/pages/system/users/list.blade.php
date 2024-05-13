@extends('layouts.master')
@section('title', 'Usuarios')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Gestion</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </div>
            <h4 class="page-title">Usuarios</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">

        <div class="card">
            <div class="card-header">
                <h4>Lista de usuarios</h4>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="#!" data-toggle="modal" data-target="#modal-register-user">Nuevo <i class="mdi mdi-plus mr-1"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <div class="dropdown float-left">
                                            <a href="#" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="true">
                                                Exportar <i class="mdi mdi-download mr-1"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 22px, 0px);">
                                                <a href="#!" class="dropdown-item"> <i class="mdi mdi-file-pdf-outline mr-1"></i> PDF</a>
                                                <a href="#!" class="dropdown-item"> <i class="mdi mdi-file-excel-outline mr-1"></i> Excel</a>
                                            </div>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <table id="listUser" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Estatus</th>
                                    <th>Nombre Completo</th>
                                    <th>Rol</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Departamento</th>
                                    <th>Area</th>
                                    <th>Fecha de registro</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

{{-- Includes de componentes --}}
@include('pages.system.users.shared.modal')
@include('pages.system.users.shared.register')

@section('js')
    <script type="text/javascript">
        "use strict";
        
        $(document).ready(function() {
            $('#listUser').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": true,
                "responsive": true,
                "order": [[1, 'DESC']],
                "lengthMenu": [[20, 25, 50, 100, -1], [20, 25, 50, 100, 'TODO']],
                "language": {
                    url: "{{ asset('json/datatable-es.json') }}"
                },
                "ajax": "{{ route('listUser') }}",
                "columns": [
                    {"data": "options"},
                    {"data": "is_active"},
                    {"data": "name"},
                    {"data": "role"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "department"},
                    {"data": "position"},
                    {"data": "created_at"}
                ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
        });

        const action = async (accion, uuid) => {
        try {
            if (accion !== 1 && accion !== 2 && accion !== 3)
                notification('Info', 'warning', `La acción ${accion} no está soportada`);

            const operaciones = {
                1: 'detalle',
                2: 'editar',
                3: 'eliminar',
            };

            const pregunta = {
                1: 'Ver informacion detallada',
                2: '¿Está seguro de que desea editar este registro?',
                3: '¿Está seguro de que desea eliminar este registro?',
            };

            const confirmacion = {
                1: 'Sí, acepto',
                2: 'Sí, editar',
                3: 'Sí, eliminar',
            };

            const alerta = await Swal.fire({
                title: pregunta[accion],
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: confirmacion[accion],
                cancelButtonText: 'Cancelar',
            });

            if (alerta.isConfirmed) {
                let url = '';
                let actions = '';
                let body;

                if (accion == 1) {
                    url = `/administracion/usuario/${uuid}`;
                    actions = 'GET';
                }

                if (accion == 2) {
                    url = '';
                    actions = '';
                }

                if (accion == 3) {
                    url = `/administracion/usuario`;
                    actions = 'POST';
                    body = uuid;
                }

                fetchData(url, actions, body)
                    .then(result => {
                        if (result.success) {
                            const data = result.data;
                            switch (accion) {
                                case 1:
                                        $('#modal-user').modal('show');
                                        document.getElementById('name').innerHTML = data.name;
                                        document.getElementById('email').innerHTML = data.email;
                                        document.getElementById('role').innerHTML = data.role;
                                        document.getElementById('phone').innerHTML = data.phone;
                                        document.getElementById('department').innerHTML = data.department;
                                        document.getElementById('position').innerHTML = data.position;
                                        document.getElementById('last_login').innerHTML = data.last_login ?? 'N/A';
                                        document.getElementById('is_active').innerHTML = data.is_active ? 'Activo' : 'Inactivo';
                                        document.getElementById('notes').innerHTML = data.notes ?? '';
                                    break;

                                case 2:
                                    $('#modal-register-user').modal('show');

                                    break

                                case 3:
                                        notification('Success', 'success', result.message);
                                        $('#listUser').DataTable().ajax.reload();
                                    break
                            
                                default:
                                    break;
                            }
                        }
                        else {
                            notification('Error', 'Error', result.message);
                        }
                    })
                    .catch(error => {
                        notification('Error', 'Error', error.message);
                    });
            }
        } catch (error) {
            notification('Error', 'La operacion fallo. Intenta nuevamente y si el problema persiste comuniquese con soporte tecnico..');
        }
    };

    </script>
@endsection
@endsection