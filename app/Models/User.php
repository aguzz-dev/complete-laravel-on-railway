<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'dni',
        'grado',
        'nombre',
        'apellido',
        'email',
        'password',
        'unit_id',
        'status'
    ];

    public function username()
    {
        return 'dni';
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_users')
            ->withPivot('date')
            ->withTimestamps();
    }



    public static function registro($request)
    {
        return self::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status
        ]);
    }
}
