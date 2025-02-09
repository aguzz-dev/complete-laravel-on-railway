<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class FoodUser extends Model
{
    protected $fillable = ['user_id', 'food_id', 'date'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Food
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
