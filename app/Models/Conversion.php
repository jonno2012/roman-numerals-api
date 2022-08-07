<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = ['integer', 'numeral', 'count'];

    use HasFactory;
}
