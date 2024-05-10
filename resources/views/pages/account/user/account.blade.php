@extends('layouts.master')
@section('title', 'Dashboard')
@section('container')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Opciones</a></li>
                    <li class="breadcrumb-item active">Cuenta</li>
                </ol>
            </div>
            <h4 class="page-title">Cuenta</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">

        <div class="card bg-primary">
            <div class="card-body profile-user-box">

                <div class="row">
                    <div class="col-sm-8">
                        <div class="media">
                            <span class="float-left m-2 mr-4">
                                <img src="https://ui-avatars.com/api/?name={{ $account->name }}" style="height: 100px;" alt="" class="rounded-circle img-thumbnail">
                            </span>
                            <div class="media-body">

                                <h4 class="mt-1 mb-1 text-white">{{ $account->name }}</h4>
                                <p class="font-13 text-white-50">{{ $account->roles[0]->name }}</p>

                                <ul class="mb-0 list-inline text-light">
                                    <li class="list-inline-item mr-3">
                                        @if ($account->is_active)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                        <p class="mb-0 font-13 text-white-50">Estatus</p>
                                    </li>
                                    <li class="list-inline-item">
                                        <h5 class="mb-1">{{ date('d-m-Y', strtotime($account->last_login)) }}</h5>
                                        <p class="mb-0 font-13 text-white-50">Ultima fecha de inicio de sesion.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="text-center mt-sm-0 mt-3 text-sm-right">
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#account-form-edit">
                                <i class="mdi mdi-account-edit mr-1"></i> Editar Perfil
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-lg-4">

        <div class="card">
            <div class="card-body">
                <h4 class="header-title mt-0 mb-3">Mas informacion</h4>
                <p class="text-muted font-13">
                    {{ $account->notes ?? 'Sin informacion' }}
                </p>

                <hr />

                <div class="text-left">
                    <p class="text-muted"><strong>Nombre completo :</strong> <span class="ml-2">Michael A. Franklin</span></p>

                    <p class="text-muted"><strong>Celular :</strong><span class="ml-2">(+52) {{ $account->phone ?? 0000-0000-00 }}</span></p>

                    <p class="text-muted"><strong>Email :</strong> <span class="ml-2">{{ $account->email }}</span></p>

                    <p class="text-muted"><strong>Ubicacion :</strong> <span class="ml-2">MX</span></p>

                    <p class="text-muted"><strong>Lenguaje :</strong>
                        <span class="ml-2">Espanol</span>
                    </p>

                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-8">

        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Orders & Revenue</h4>
                <div style="height: 260px;" class="chartjs-chart">
                    <canvas id="high-performing-product"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-basket float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Orders</h6>
                        <h2 class="m-b-20">1,587</h2>
                        <span class="badge badge-primary"> +11% </span> <span class="text-muted">From previous
                            period</span>
                    </div>
                </div>

            </div>

            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-box float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Revenue</h6>
                        <h2 class="m-b-20">$<span>46,782</span></h2>
                        <span class="badge badge-danger"> -29% </span> <span class="text-muted">From previous
                            period</span>
                    </div>
                </div>

            </div>

            <div class="col-sm-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class="dripicons-jewel float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                        <h2 class="m-b-20">1,890</h2>
                        <span class="badge badge-primary"> +89% </span> <span class="text-muted">Last year</span>
                    </div>
                </div>

            </div>

        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">My Products</h4>

                <div class="table-responsive">
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ASOS Ridley High Waist</td>
                                <td>$79.49</td>
                                <td><span class="badge badge-primary">82 Pcs</span></td>
                                <td>$6,518.18</td>
                            </tr>
                            <tr>
                                <td>Marco Lightweight Shirt</td>
                                <td>$128.50</td>
                                <td><span class="badge badge-primary">37 Pcs</span></td>
                                <td>$4,754.50</td>
                            </tr>
                            <tr>
                                <td>Half Sleeve Shirt</td>
                                <td>$39.99</td>
                                <td><span class="badge badge-primary">64 Pcs</span></td>
                                <td>$2,559.36</td>
                            </tr>
                            <tr>
                                <td>Lightweight Jacket</td>
                                <td>$20.00</td>
                                <td><span class="badge badge-primary">184 Pcs</span></td>
                                <td>$3,680.00</td>
                            </tr>
                            <tr>
                                <td>Marco Shoes</td>
                                <td>$28.49</td>
                                <td><span class="badge badge-primary">69 Pcs</span></td>
                                <td>$1,965.81</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

@include('pages.account.user.modals.account_edit')

@section('js')
    <script src="{{ asset('assets/js/vendor/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.profile.js') }}"></script>  
@endsection

@endsection