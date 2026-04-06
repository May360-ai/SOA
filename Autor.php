<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';
    protected $primaryKey = 'dni';
    protected $keyType= 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'dni',
        'nombre',
        'nacionalidad',
    ];
    public function libros(){
        return $this->hasMany(Libro::class, 'autor_dni', 'dni');
    }
    
}
