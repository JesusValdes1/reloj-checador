<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecadorRegistro extends Model
{
    use HasFactory;

    protected $table = 'checador_registros';

    protected $fillable = [ 'checador_id', 'empleado_id', 'entrada', 'fecha'];

    public function checador()
    {
        return $this->belongsTo(Checador::class, 'checador_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
