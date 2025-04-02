<template>
    <div class="container">
        <div class="d-grid p-2" v-if="nuevo==false">
            <button class="btn btn-primary btn-lg" type="button" @click="toggleNuevo">Nuevo contacto</button>
        </div>
        <form class="p-3" @submit.prevent="crearContacto"  v-if="nuevo">
            <h3>Nuevo contacto</h3>
            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="inputNombre" name="nombre" v-model="contacto.nombre">
            </div>
            <div class="mb-3">
                <label for="inputTelefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="inputTelefono" name="telefono" v-model="contacto.telefono">
            </div>
            <div class="mb-3">
                <label class="form-label" for="inputFechaNacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="inputFechaNacimiento" name="fechaNacimiento" v-model="contacto.fecha_nacimiento">
            </div>
            <button class="btn btn-primary" type="submit">Crear contacto</button>
            <button class="btn btn-danger ms-2" type="button" @click="cancelarNuevo">Cancelar</button>
        </form>
        <form class="p-3" v-if="editar" @submit.prevent="actualizarContacto(contacto)">
            <h3>Editar contacto</h3>
            <div class="mb-3">
                <label for="inputNombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="inputNombre" name="nombre" v-model="contacto.nombre">
            </div>
            <div class="mb-3">
                <label for="inputTelefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="inputTelefono" name="telefono" v-model="contacto.telefono">
            </div>
            <div class="mb-3">
                <label class="form-label" for="inputFechaNacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="inputFechaNacimiento" name="fechaNacimiento" v-model="contacto.fecha_nacimiento">
            </div>
            <button class="btn btn-primary" type="submit">Actualizar contacto</button>
            <button class="btn btn-danger ms-2" type="button" @click="cancelarEditar">Cancelar</button>
        </form>
        <table class="table mt-2 p-3">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Fecha de nacimiento</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,index) in contactos">
                    <th scope="row">{{ item.id_contacto }}</th>
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.telefono }}</td>
                    <td>{{ item.fecha_nacimiento }}</td>
                    <td>
                        <button class="btn btn-warning" type="button" @click="toggleEditar(item)">Editar</button>
                        <button class="btn btn-danger ms-1" type="button" @click="eliminarContacto(item,index)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                nuevo: false,
                editar: false,
                contactos: [],
                contacto: {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
            }
        },
        async created(){
            try {
                const response = await axios.get("/api/contacto");
                this.contactos = response.data;
                console.log(response);
            } catch (error) {
                console.log(error);
            }
        },
        methods:{
            toggleEditar(item){
                this.contacto.id_contacto = item.id_contacto;
                this.contacto.nombre = item.nombre;
                this.contacto.telefono = item.telefono;
                this.contacto.fecha_nacimiento = item.fecha_nacimiento;
                this.editar = true;
                this.nuevo = false;
            },
            toggleNuevo(){
                this.nuevo = !this.nuevo
                this.editar = false
                this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
            },
            cancelarNuevo(){
                this.nuevo = false;
                this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
            },
            cancelarEditar(){
                this.editar=false,
                this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
            },
            async crearContacto(){
                if(this.contacto.nombre.trim()==""||this.contacto.telefono.trim()==""||this.contacto.fecha_nacimiento.trim()==""){
                    alert('Debes llenar todos los campos del formulario')
                }else{
                    var data = {
                        nombre: this.contacto.nombre,
                        telefono: this.contacto.telefono,
                        fecha_nacimiento: this.contacto.fecha_nacimiento
                    }
                    try {
                        const response = await axios.post('/api/contacto', data);
                        const nuevoContacto = response.data.result
                        this.contactos.push(nuevoContacto)
                        this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
                        this.nuevo = false;
                        alert('Contacto creado exitosamente')
                    } catch (error) {
                        console.log(error.response);
                        this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
                        alert("Ocurrió un error al crear el contacto")
                    }
                }
            },
            async actualizarContacto(contacto){
                if(contacto.nombre.trim()==""||!contacto.telefono||contacto.fecha_nacimiento.trim()==""){
                    alert('Debes llenar todos los campos del formulario')
                }else{
                    var data = {
                        nombre: contacto.nombre,
                        telefono: contacto.telefono,
                        fecha_nacimiento: contacto.fecha_nacimiento
                    }
                    try {
                        const response = await axios.patch(`/api/contacto/${contacto.id_contacto}`, data);
                        const actualizado = response.data.result
                        const index = this.contactos.findIndex(item => item.id_contacto === contacto.id_contacto)
                        this.contactos[index] = actualizado
                        this.contacto = {id_contacto:'', nombre: '', telefono: '', fecha_nacimiento: ''}
                        this.editar = false;
                        alert('Contacto actualizado exitosamente')
                    } catch (error) {
                        console.log(error);
                        alert("Ocurrió un error al actualizar el contacto")
                    }
                }
            },
            async eliminarContacto(contacto, index){
                try {
                    const response = await axios.delete(`/api/contacto/${contacto.id_contacto}`)
                    this.contactos.splice(index,1)
                    alert(response.data.result)
                } catch (error) {
                    console.log(error);
                    alert(error.response.data.errors)
                }
            }
        }
    }
</script>