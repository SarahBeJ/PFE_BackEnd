<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
class Departement extends Authenticatable
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'questions';
    protected $casts = [
        'Departement' => 'array',


    ];
    protected $fillable = [
        'nom',
        'chef',
        'etat',
        

    ];
}
