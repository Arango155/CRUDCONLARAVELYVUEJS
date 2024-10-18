// Configuración de Toastr (fuera de la instancia Vue)
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
}

// Instancia de Vue
new Vue({
    el: '#app',

    data: {
        // Datos para categorías
        items: [],
        newItem: { nombre: '' },
        fillItem: { id: '', nombre: '' },

        // Datos para libros
        libros: [],
        newLibro: {
            nombre: '',
            autor: '',
            categoria_id: '',
            estado_id: '',
            descripcion: '',
            img: ''
        },
        fillLibro: {
            id: '',
            nombre: '',
            autor: '',
            categoria_id: '',
            estado_id: '',
            descripcion: '',
            img: ''
        },
        
        // Errores compartidos
        errors: [],
    },

    mounted() {
        // Obtener datos de la API al montar el componente
        this.getItems();
        this.getLibros();
    },

    

    methods: {


        

        // Métodos para manejar categorías
        getItems() {
            axios.get('/api/categorias')
                .then(response => {
                    this.items = response.data;
                })
                .catch(error => {
                    console.log('Error fetching categories:', error);
                    toastr.error('Error al obtener las categorías.');
                });
        },
        addItem() {
            axios.post('/storeC', this.newItem)
                .then(response => {
                    if (response.data.category) {
                        this.items.push(response.data.category);
                    } else {
                        toastr.error('La categoría fue agregada, pero la estructura de datos no es la esperada.');
                    }
                    this.newItem = { nombre: '' };
                    this.errors = [];
                    toastr.success('Categoría agregada correctamente.');
                })
                .catch(error => {
                    toastr.error(error.response.data.error);
                    console.log('Error adding item:', error);
                    this.handleErrors(error);
                });
        },
        editItem(item) {
            this.fillItem.id = item.id;
            this.fillItem.nombre = item.nombre;
            $('#edit').modal('show');
        },
        updateItem(id) {
            axios.put('/categorias/' + id, this.fillItem)
                .then(response => {
                    const index = this.items.findIndex(item => item.id === id);
                    if (index !== -1) {
                        this.items.splice(index, 1, response.data);
                    }
                    $('#edit').modal('hide');
                    this.fillItem = { id: '', nombre: '' };
                    this.errors = [];
                    toastr.success('Categoría actualizada correctamente.');
                })
                .catch(error => {
                    toastr.error('Error al actualizar la categoria:', error);
                    console.log('Error updating item:', error);
                    this.handleErrors(error);
                });
        },
        deleteItem(id) {
            axios.delete('/categorias/' + id)
                .then(response => {
                    const index = this.items.findIndex(item => item.id === id);
                    if (index !== -1) {
                        this.items.splice(index, 1);
                    }
                    toastr.success('Categoría eliminada correctamente.');
                })
                .catch(error => {
                    console.log('Error deleting item:', error);
                    toastr.error('Hubo un error al eliminar la categoría.');
                });
        },

        // Métodos para manejar libros
        getLibros() {
            axios.get('/api/libros')
                .then(response => {
                    this.libros = response.data;
                })
                .catch(error => {
                    console.log('Error fetching libros:', error);
                    toastr.error('Error al obtener los libros.');
                });
        },
        addLibro() {
            axios.post('/storeLibro', this.newLibro)
                .then(response => {
                    if (response.data.libro) {
                        this.libros.push(response.data.libro);
                    } else {
                        toastr.error('El libro fue agregado, pero la estructura de datos no es la esperada.');
                    }
                    this.newLibro = { nombre: '', autor: '', categoria_id: '', estado_id: '', descripcion: '', img: '' };
                    this.errors = [];
                    toastr.success('Libro agregado correctamente.');
                })
                .catch(error => {
                    toastr.error(error.response.data.error);
                    console.log('Error adding libro:', error);
                    this.handleErrors(error);
                });
        },
        editLibro(libro) {
            this.fillLibro.id = libro.id;
            this.fillLibro.nombre = libro.nombre;
            this.fillLibro.autor = libro.autor;
            this.fillLibro.categoria_id = libro.categoria_id;
            this.fillLibro.estado_id = libro.estado_id;
            this.fillLibro.descripcion = libro.descripcion;
            // this.fillLibro.img = libro.img;
            $('#edit').modal('show');
        },
        updateLibro(id) {
            axios.put('/libros/' + id, this.fillLibro)
                .then(response => {
                    console.log(response.data);  // Log response data to check what's coming back
                    const index = this.libros.findIndex(libro => libro.id === id);
                    if (index !== -1) {
                        this.libros.splice(index, 1, response.data);
                    }
                    $('#edit').modal('hide');
                    toastr.success('Libro actualizado correctamente.');
                })
                .catch(error => {
                    console.error('Error al actualizar libro:', error.response.data);
                    toastr.error('Error al actualizar libro:', error.response.data.message || 'Unknown error');
                });
        },
        
        deleteLibro(id) {
            axios.delete('/libros/' + id)
                .then(response => {
                    const index = this.libros.findIndex(libro => libro.id === id);
                    if (index !== -1) {
                        this.libros.splice(index, 1);
                    }
                    toastr.success('Libro eliminado correctamente.');
                })
                .catch(error => {
                    console.log('Error deleting libro:', error);
                    toastr.error('Hubo un error al eliminar el libro.');
                });
        },

        // Manejar errores de la API (compartido)
        handleErrors(error) {
            if (error.response) {
                this.errors = error.response.data.errors
                    ? error.response.data.errors.nombre || ['Ocurrió un error inesperado.']
                    : [error.response.data];
            } else {
                toastr.error('Error en el servidor.');
            }
        }
    }
});
