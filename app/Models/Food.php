<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = ['descripcion', 'precio', 'status', 'unit_id'];
    public $timestamps = false; // Desactiva timestamps


    // Relación inversa con FoodUser
    public function foodUsers()
    {
        return $this->hasMany(FoodUser::class);
    }
}
