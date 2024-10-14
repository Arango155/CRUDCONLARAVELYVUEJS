<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Add the 'fillable' property to allow mass assignment of specific fields
    protected $fillable = ['nombre'];
}
