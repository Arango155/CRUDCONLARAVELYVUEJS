<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'nombre', 
        'autor', 
        'categoria_id', 
        'estado_id', 
        'descripcion', 
        // Add other fields that you want to allow for mass assignment
    ];

    // Define relationships to other models
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
