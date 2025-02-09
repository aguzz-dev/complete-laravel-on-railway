<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


abstract class Controller
{
    use HasApiTokens, Notifiable;
}
