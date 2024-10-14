@extends('templates/adminbase')

@section('body')

<div id="app">
    <div class="container">
        <div class="tab">
            <h3>Listado en el sistema</h3>

     
                <!-- Add Category Form with Error Display -->
            <form @submit.prevent="addItem">
                <input type="text" v-model="newItem.nombre" placeholder="Nombre de la Categoria" required>
                <span v-if="errors.length" class="text-danger">@{{ errors[0] }}</span> <!-- Error Display -->
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>


            

            <hr>

            <div class="table-responsive">
                <table id="table" class="table table-sm table-bordered">
                    <thead>
                        <tr>
                        
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.id">
                         
                            <td>@{{ item.nombre }}</td>
                            <td>
                                <button @click="editItem(item)" class="btn btn-warning">✏️</button>
                                <button @click="deleteItem(item.id)" class="btn btn-danger">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- Edit Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form @submit.prevent="updateItem(fillItem.id)">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Edit Category</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <input type="text" v-model="fillItem.nombre" placeholder="Nombre de la Categoria" required>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                     -->
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>


    </div>
</div>

@endsection
