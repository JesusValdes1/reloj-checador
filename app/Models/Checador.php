<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checador extends Model
{
    use HasFactory;

    protected $table = 'checadores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'ip', 'activo', 'nombre', 'descripcion', 'ubicacion' ];
}
