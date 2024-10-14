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
        items: [],  // Array para almacenar categorías
        newItem: { nombre: '' },  // Modelo para agregar una nueva categoría
        fillItem: { id: '', nombre: '' },  // Modelo para editar una categoría
        errors: []  // Manejo de errores
    },
    mounted() {
        // Obtener los datos de la API al montar el componente
        this.getItems();
    },
    methods: {
        // Obtener categorías desde la API
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

        // Agregar nueva categoría
        // Agregar nueva categoría
// Agregar nueva categoría
addItem() {
    console.log('Adding item:', this.newItem);
    axios.post('/storeC', this.newItem)
        .then(response => {
            // Check the response data structure
            console.log('Response from addItem:', response.data);

            // Add the new category from the response directly to the items array
            if (response.data.category) {
                this.items.push(response.data.category); // Now includes the full category object
            } else {
                console.error('Unexpected response structure:', response.data);
                toastr.error('La categoría fue agregada, pero la estructura de datos no es la esperada.');
            }

            this.newItem = { nombre: '' };  // Clear the form
            this.errors = [];  // Clear previous errors
            toastr.success('Categoría agregada correctamente.');
        })
        .catch(error => {
            console.log('Error adding item:', error);
            this.handleErrors(error);
        });
}


        
        
        
        
        ,

        // Editar un ítem (abrir el modal con los datos del ítem seleccionado)
        editItem(item) {
            this.fillItem.id = item.id;
            this.fillItem.nombre = item.nombre;
            $('#edit').modal('show');  // Mostrar el modal
        },

        // Actualizar el ítem
        updateItem(id) {
            axios.put('/categorias/' + id, this.fillItem)
                .then(response => {
                    // Buscar y actualizar el ítem en el array de items
                    const index = this.items.findIndex(item => item.id === id);
                    if (index !== -1) {
                        this.items.splice(index, 1, response.data);  // Reemplazar el ítem actualizado
                    }
                    $('#edit').modal('hide');  // Ocultar el modal
                    this.fillItem = { id: '', nombre: '' };  // Limpiar el formulario
                    this.errors = [];  // Limpiar errores previos
                    toastr.success('Categoría actualizada correctamente.');
                })
                .catch(error => {
                    console.log('Error updating item:', error);
                    this.handleErrors(error);
                });
        },

        // Eliminar un ítem
        deleteItem(id) {
            axios.delete('/categorias/' + id)
                .then(response => {
                    // Buscar y eliminar el ítem en el array de items
                    const index = this.items.findIndex(item => item.id === id);
                    if (index !== -1) {
                        this.items.splice(index, 1);  // Eliminar el ítem del array
                    }
                    toastr.success('Categoría eliminada correctamente.');
                })
                .catch(error => {
                    console.log('Error deleting item:', error);
                    toastr.error('Hubo un error al eliminar la categoría.');
                });
        }
    }
});
