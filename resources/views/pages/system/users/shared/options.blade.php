<div class="dropdown float-left">
    <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-toggle="dropdown" aria-expanded="true">
        <i class="mdi mdi-xbox-controller-menu mr-1"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 22px, 0px);">
        <a href="#!" class="dropdown-item" onclick="action(1, '{{ $uuid }}')"> <i class="mdi mdi-eye-outline mr-1"></i> Detalle usuario</a>
        <a href="#!" class="dropdown-item"> <i class="mdi mdi-pencil-outline mr-1"></i> Editar usuario</a>
        <a href="#!" class="dropdown-item" onclick="action(3, '{{ $uuid }}')"> <i class="mdi mdi-trash-can-outline mr-1"></i> Eliminar usuario</a>
    </div>
</div>