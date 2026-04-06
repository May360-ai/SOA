<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libro';
    protected $primaryKey = 'codigo';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'codigo',
        'titulo',
        'autor_dni'
    ];
    public function autor()
    {
    return $this->belongsTo(Autor::class, 'autor_dni', 'dni');
    }
}
