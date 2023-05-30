<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'po', 'itemref', 'company', 'category', 'type', 'price', 'description', 'images','file','pdf', 'addedby','updatedby','archived',
    ];
    public $timestamps = false;
}
