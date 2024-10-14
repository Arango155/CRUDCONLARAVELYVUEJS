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
        errors: [],
    },

    mounted() {
        // Obtener los datos de la API al montar el componente
        this.getLibros();
    },

    methods: {
        // Obtener libros desde la API
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

        // Manejar errores de la API
        handleErrors(error) {
            if (error.response) {
                this.errors = error.response.data.errors
                    ? error.response.data.errors.nombre || ['Ocurrió un error inesperado.']
                    : [error.response.data];
            } else {
                toastr.error('Error en el servidor.');
            }
        },

        // Agregar un nuevo libro
        addLibro() {
            console.log('Adding libro:', this.newLibro);
            axios.post('/storeLibro', this.newLibro)
                .then(response => {
                    if (response.data.libro) {
                        this.libros.push(response.data.libro); // Agregar el libro al array
                    } else {
                        console.error('Unexpected response structure:', response.data);
                        toastr.error('El libro fue agregado, pero la estructura de datos no es la esperada.');
                    }

                    this.newLibro = { nombre: '', autor: '', categoria_id: '', estado_id: '', descripcion: '', img: '' };  // Limpiar el formulario
                    this.errors = [];  // Limpiar errores previos
                    toastr.success('Libro agregado correctamente.');
                })
                .catch(error => {
                    console.log('Error adding libro:', error);
                    this.handleErrors(error);
                });
        },

        // Editar un libro (abrir el modal con los datos del libro seleccionado)
        editLibro(libro) {
            this.fillLibro.id = libro.id;
            this.fillLibro.nombre = libro.nombre;
            this.fillLibro.autor = libro.autor;
            this.fillLibro.categoria_id = libro.categoria_id;
            this.fillLibro.estado_id = libro.estado_id;
            this.fillLibro.descripcion = libro.descripcion;
            this.fillLibro.img = libro.img;
            $('#edit').modal('show');  // Mostrar el modal
        },

        // Actualizar el libro
        updateLibro(id) {
            axios.put('/libros/' + id, this.fillLibro)
                .then(response => {
                    const index = this.libros.findIndex(libro => libro.id === id);
                    if (index !== -1) {
                        this.libros.splice(index, 1, response.data);  // Reemplazar el libro actualizado
                    }
                    $('#edit').modal('hide');  // Ocultar el modal
                    this.fillLibro = { id: '', nombre: '', autor: '', categoria_id: '', estado_id: '', descripcion: '', img: '' };  // Limpiar el formulario
                    this.errors = [];  // Limpiar errores previos
                    toastr.success('Libro actualizado correctamente.');
                })
                .catch(error => {
                    console.log('Error updating libro:', error);
                    this.handleErrors(error);
                });
        },

        // Eliminar un libro
        deleteLibro(id) {
            axios.delete('/libros/' + id)
                .then(response => {
                    const index = this.libros.findIndex(libro => libro.id === id);
                    if (index !== -1) {
                        this.libros.splice(index, 1);  // Eliminar el libro del array
                    }
                    toastr.success('Libro eliminado correctamente.');
                })
                .catch(error => {
                    console.log('Error deleting libro:', error);
                    toastr.error('Hubo un error al eliminar el libro.');
                });
        }
    }
});
