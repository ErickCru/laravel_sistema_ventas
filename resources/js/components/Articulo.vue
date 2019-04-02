<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Artículos
                        <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="text-center">
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categorías</th>
                                    <th>Precio venta</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('articulo','actualizar', articulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion">
                                            <button type="button" @click="desactivarArticulo(articulo.id)" class="btn btn-danger btn-sm">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" @click="activarArticulo(articulo.id)" class="btn btn-info btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="articulo.codigo"></td>
                                    <td v-text="articulo.nombre"></td>
                                    <td v-text="articulo.nombre_categoria"></td>
                                    <td v-text="articulo.precio_venta"></td>
                                    <td v-text="articulo.stock"></td>
                                    <td v-text="articulo.descripcion"></td>                                   
                                    <td>
                                        <div v-if="articulo.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActivated ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar, criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione </option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras">
                                        <barcode :value="codigo" :options="{format: 'EAN-13' }">
                                            Generando código de barras.
                                        </barcode>
                                    </div>
                                </div>
                                <div class="form-group row"> 
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio de venta</label>
                                    <div class="col-md-9">
                                        <input type="number" min="0" v-model="precio_venta" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" min="0" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" @click="registrarArticulo()" class="btn btn-primary">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" @click="actualizarArticulo()" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
        </main>      

</template>

<script>
    import VueBarcode from 'vue-barcode';

    export default {
        data(){
            return{
                articulo_id: 0,
                idcategoria: 0,
                codigo: '',
                nombre: '',
                nombre_categoria: '',
                precio_venta: 0,
                stock: 0,
                descripcion: '',
                arrayArticulo: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorArticulo: 0,
                errorMostrarMsjArticulo: [],
                pagination: {
                    'total'        :0,
                    'current_page' :0,
                    'per_page'     :0,
                    'last_page'    :0,
                    'from'         :0,
                    'to'           :0,
                },
                offset: 3,
                criterio: 'nombre',
                buscar: '',
                arrayCategoria: [],
            }
        },
        components: {
            'barcode': VueBarcode
        }
        ,
        computed: {
            isActivated: function(){
                return this.pagination.current_page;
            },
            //Calcular los elementos de la paginación
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if(from < 1) {from = 1;}

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){to = this.pagination.last_page;}

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
            
        },
        methods: {
            listarArticulo(page, buscar, criterio){
                let me = this;
                var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url)
                .then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    if(respuesta.articulos.data.length != 0){
                        me.arrayArticulo = respuesta.articulos.data;
                        me.pagination = respuesta.pagination;
                    }
                    else{
                        Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'No se encontró ningún registro con ese dato',
                        footer: 'Intente con otro dato.'
                        })
                        me.arrayArticulo = respuesta.articulos.data;
                        me.pagination = respuesta.pagination;
                    }
                    
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            selectCategoria(){
                let me = this;
                var url = '/categoria/selectCategoria';
                axios.get(url)
                .then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;  
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page , buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarArticulo(page, buscar, criterio);
            },
            registrarArticulo(){
                if(this.validarArticulo()){return;}

                let me = this;
                axios.post('/articulo/registrar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion
                })
                .then(function (response) {
                    // handle success
                    me.cerrarModal();
                    me.listarArticulo(1, '', 'nombre');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.buscar = '';

            },
            actualizarArticulo(){
                if(this.validarArticulo()){return;}

                let me = this;
                axios.put('/articulo/actualizar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                })
                .then(function (response) {
                    // handle success
                    me.cerrarModal();
                    me.listarArticulo(1, '', 'nombre');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: '¿Esta seguro de desactivar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Acepto',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/desactivar',{
                        'id': id
                    })
                    .then(function (response) {
                        // handle success
                        me.listarArticulo(1, '', 'nombre');
                        swalWithBootstrapButtons.fire(
                        '¡Desactivado!',
                        'El registro ha sido desactivado exitosamente.',
                        'success'
                        )
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });

                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {}                  
                })
            },
            activarArticulo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: '¿Esta seguro de activar este artículo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Acepto',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/activar',{
                        'id': id
                    })
                    .then(function (response) {
                        // handle success
                        me.listarArticulo(1, '', 'nombre');
                        swalWithBootstrapButtons.fire(
                        '¡Activado!',
                        'El registro ha sido activado exitosamente.',
                        'success'
                        )
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });

                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {}                  
                })
            },
            validarArticulo(){
                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];

                if(this.idcategoria == 0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if(!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if(!this.stock || this.stock < 0 ) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número positivo y no puede estar vacío.");
                if(!this.precio_venta || this.precio_venta < 0) this.errorMostrarMsjArticulo.push("El precio de venta del artículo debe ser un número positivo y no puede estar vacío.");

                if(this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":{
                        switch(accion){
                            case "registrar":{
                                this.modal = 1;
                                this.tituloModal = 'Registrar Artículo';
                                this.idcategoria = 0;
                                this.nombre_categoria = '';
                                this.codigo = '';
                                this.nombre = '';
                                this.precio_venta = 0; 
                                this.stock = 0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }

                            case "actualizar":{
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Artículo';
                                this.tipoAccion = 2;
                                this.articulo_id = data['id'];
                                this.idcategoria = data['idcategoria'];
                                this.codigo = data['codigo'];
                                this.nombre = data['nombre'];
                                this.precio_venta = data['precio_venta']
                                this.stock = data['stock'];
                                this.descripcion = data['descripcion'];
                                break;
                            }
                            
                        }
                        break;
                    }
                }
                this.selectCategoria();
                //console.log(this.arrayCategoria);
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idcategoria = 0;
                this.codigo = '';
                this.nombre_categoria = '';
                this.precio_venta = 0;
                this.stock =  0;
                this.descripcion = '';
                this.nombre = '';
                this.errorArticulo = 0;
            },
        },
        mounted() {
            this.listarArticulo(1, this.nombre, this.criterio);
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    td, th{
        text-align: center;
    }
</style>
