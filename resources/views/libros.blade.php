@extends('templates/adminbase')

@section('body')

<div id="app">
    <div class="container">
        <div class="tab">
            <h3>Listado de Libros en el Sistema</h3>

            <!-- Add Book Form with Error Display -->
            <form @submit.prevent="addLibro">
                <input type="text" v-model="newLibro.nombre" placeholder="Nombre del Libro" required>
                <input type="text" v-model="newLibro.autor" placeholder="Autor del Libro" required>
                <input type="number" v-model="newLibro.categoria_id" placeholder="ID de la Categoria" required>
                <input type="number" v-model="newLibro.estado_id" placeholder="ID del Estado" required>
                <input type="text" v-model="newLibro.descripcion" placeholder="Descripción" required>
                <input type="url" v-model="newLibro.img" placeholder="URL de la Imagen" required>

                <!-- <span v-if="errors.length" class="text-danger">@{{ errors[0] }}</span>  -->
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>

            <hr>

            <div class="table-responsive">
                <table id="table" class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Autor</th>
                            <th>Categoria</th>
                            <th>Estado</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="libro in libros" :key="libro.id">
                            <td>@{{ libro.nombre }}</td>
                            <td>@{{ libro.autor }}</td>
                            <td>@{{ libro.categoria_id }}</td>
                            <td>@{{ libro.estado_id }}</td>
                            <td>@{{ libro.descripcion }}</td>
                            <td><img :src="'images/' + libro.img" alt="Imagen del libro" style="width:100px;"></td>

                            <td>
                                <button @click="editLibro(libro)" class="btn btn-warning">✏️</button>
                                <button @click="deleteLibro(libro.id)" class="btn btn-danger">🗑️</button>
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
                    <form @submit.prevent="updateLibro(fillLibro.id)">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLabel">Editar Libro</h5>
                        </div>
                        <div class="modal-body">
                            <input type="text" v-model="fillLibro.nombre" placeholder="Nombre del Libro" required>
                            <input type="text" v-model="fillLibro.autor" placeholder="Autor del Libro" required>
                            <input type="number" v-model="fillLibro.categoria_id" placeholder="ID de la Categoria" required>
                            <input type="number" v-model="fillLibro.estado_id" placeholder="ID del Estado" required>
                            <input type="text" v-model="fillLibro.descripcion" placeholder="Descripción" required>
                            <!-- <input type="url" v-model="fillLibro.img" placeholder="URL de la Imagen" required> -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
