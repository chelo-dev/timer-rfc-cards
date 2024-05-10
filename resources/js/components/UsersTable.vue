<template>
    <div class="table-responsive">
        <div class="input-group col-md-3 py-2">
            <input type="text" v-model="search" class="form-control" placeholder="Nombre" />
        </div>
        <table class="table dt-responsive nowrap w-100">
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
            <tbody>
                <tr v-for="user in filteredUsers" :key="user.id">
                    <td>
                      <div class="dropdown float-left">
                          <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-toggle="dropdown" aria-expanded="true" >
                              <i class="mdi mdi-xbox-controller-menu mr-1" ></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 22px, 0px); " >
                              <a @click="editUser(user)" type="button" class="dropdown-item">
                                  <i class="mdi mdi-pencil-outline mr-1"></i> Editar</a>
                              <a @click="deleteUser(user.id)" type="button" class="dropdown-item">
                                  <i class="mdi mdi-trash-can-outline mr-1"></i>Eliminar
                              </a>
                          </div>
                      </div>
                    </td>
                    <td v-html="user.is_active ? activeBadge : inactiveBadge"></td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.department }}</td>
                    <td>{{ user.position }}</td>
                    <td>{{ formatDate(user.created_at) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            users: [],
            activeBadge: '<span class="badge badge-success">Activo</span>',
            inactiveBadge: '<span class="badge badge-danger">Inactivo</span>'
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            axios
                .get('http://127.0.0.1:8000/lista-usuarios')
                .then((response) => {
                    this.users = response.data.data;
                    console.log(this.users);
                })
                .catch((error) => {
                    console.error("There was an error fetching the users:", error);
                });
        },
        editUser(user) {
            // Lógica para editar usuario
            console.log(user.uuid);
        },
        deleteUser(userId) {
            // Lógica para editar usuario
        },
        formatDate(dateString) {
            const options = {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            };
            return new Intl.DateTimeFormat('es-ES', options).format(new Date(dateString));
        },
    },
    computed: {
        filteredUsers() {
            return this.users.filter((user) => {
                return (
                    user.name
                        .toLowerCase()
                        .includes(this.search.toLowerCase()) ||
                    user.email.toLowerCase().includes(this.search.toLowerCase())
                );
            });
        },
    },
};
</script>
