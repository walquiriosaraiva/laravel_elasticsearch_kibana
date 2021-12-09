<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;

class Livro extends Model
{
    use HasFactory, Searchable;

    protected $table = 'livro';

    protected $primaryKey = 'id';

    protected $dates = ['data_cadastro'];

    public $timestamps = false;

    protected $fillable = ['titulo', 'descricao', 'autor', 'numero_pagina', 'data_cadastro'];
}
