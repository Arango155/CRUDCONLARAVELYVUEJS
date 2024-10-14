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
        $this->validate($request, [
            'nombre' => 'required',  // Validation rule for category name
        ]);
    
        Categoria::find($id)->update($request->all());  // Update the category
        return response()->json(['success' => 'Category updated successfully!']);
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
    
    
    




}
