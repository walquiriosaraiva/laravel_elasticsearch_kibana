<?php

namespace App\Livro;

use Illuminate\Database\Eloquent\Collection;

interface LivroRepository
{
    public function search($query = '');
}
