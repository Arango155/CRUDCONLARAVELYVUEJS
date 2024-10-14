<?php

namespace App\Http\Controllers;



use App\Exports\ExportName;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Libro;
use mysql_xdevapi\Exception;
use Excel;
use Termwind\Components\Li;


class Controller extends BaseController
{

   


    function main(){
        return view('main');
    }
    
    function index()
    {

        $items = Libro::all();
        return view('list', compact('items'));
    }

    function indexl()
    {

        $items = Libro::orderBy('autor', 'asc')->paginate(5);
        return view('libros', compact('items','items'));

    }

    function list(){
        $items = Libro::all();
        $libros = Libro::all();
        return view('list', compact('items','libros'));
    }

    function public(){
        $libros = Libro::all();
        $items = Libro::all();
        return view('public', compact('items','libros'));
    }

   



    function add()
    {
        $categoriaitem = Categoria::all();
        $estado=Estado::all();
        return view('add',compact('categoriaitem','estado'));
    }



    

  

    public function indexg() {
        $items = Categoria::orderBy('nombre', 'asc')->get();
        return response()->json($items);  // Return JSON response for Vue
    }
    
   

    public function update(Request $request, $id) {
        $request->validate([
            'nombre' => 'required',
        ]);
    
        $categoria = Categoria::find($id);
        $categoria->update($request->all());  // Update the category
    
        return response()->json($categoria);  // Return the updated category data
    }
    

    
    public function storeC(Request $request) {
        \Log::info('Request data for storeC:', $request->all()); // Log the incoming request data
    
        try {
            // Validate the incoming request data
            $request->validate([
                'nombre' => 'required|string|max:60|unique:categorias,nombre',
            ]);
    
            // Create the new category
            $categoria = Categoria::create($request->all());
    
            \Log::info('New category created:', $categoria->toArray()); // Log the new category
    
            // Return the newly created category along with a success message
            return response()->json([
                'success' => 'Category added successfully!',
                'category' => $categoria // Include the newly created category data
            ], 201);
        } catch (\Exception $e) {
            // Log the error if any exception occurs
            \Log::error('Error in storeC: ' . $e->getMessage() . ' | Request data: ' . json_encode($request->all()));
            return response()->json(['error' => 'Ha ocurrido un error al agregar esta categoria, verifica que no sea duplicada.'], 500);
        }
    }
    
    
    
    

    public function categoriasView() {
        return view('categorias');  // Return the blade view
    }

    public function destroy($id) {
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->delete();  // Elimina la categoría
            return response()->json(['success' => 'Categoría eliminada exitosamente!']);
        } else {
            return response()->json(['error' => 'Categoría no encontrada.'], 404);
        }
    }

    //Libros


    public function librosView() {
        return view('libros');  // Return the blade view
    }
    
    
    public function indexLibros() {
        // Fetch all books, ordered by their name
        $items = Libro::orderBy('nombre', 'asc')->get();
        return response()->json($items);  // Return JSON response for Vue
    }
    
    public function updateLibro(Request $request, $id) {
        // Validate the request fields for updating a book
        $request->validate([
            'nombre' => 'required|string|max:100',
            'autor' => 'required|string|max:60',
            'categoria_id' => 'required|exists:categorias,id',
            'estado_id' => 'required|exists:estados,id',
            'descripcion' => 'required|string|max:300',
            'img' => 'nullable|string|max:3000',  // Allow image to be optional
        ]);
    
        // Find the book by its ID and update it with the request data
        $libro = Libro::find($id);
        $libro->update($request->all());
    
        return response()->json($libro);  // Return the updated book data
    }
    
    public function storeLibro(Request $request) {
        \Log::info('Request data for storeLibro:', $request->all()); // Log the incoming request data
        
        try {
            // Validate the incoming request data for creating a new book
            $request->validate([
                'nombre' => 'required|string|max:100|unique:libros,nombre',
                'autor' => 'required|string|max:60',
                'categoria_id' => 'required|exists:categorias,id',
                'estado_id' => 'required|exists:estados,id',
                'descripcion' => 'required|string|max:300',
                'img' => 'nullable|string|max:3000',
            ]);
    
            // Create the new book
            $libro = Libro::create($request->all());
    
            \Log::info('New book created:', $libro->toArray()); // Log the new book
    
            // Return the newly created book along with a success message
            return response()->json([
                'success' => 'Libro agregado correctamente.',
                'libro' => $libro // Include the newly created book data
            ], 201);
        } catch (\Exception $e) {
            // Log the error if any exception occurs
            \Log::error('Error in storeLibro: ' . $e->getMessage() . ' | Request data: ' . json_encode($request->all()));
            return response()->json(['error' => 'Ha ocurrido un error al agregar este libro, verifica que no sea duplicado.'], 500);
        }
    }
    




}
