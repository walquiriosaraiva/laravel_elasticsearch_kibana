<?php

namespace App\Livro;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements LivroRepository
{
    public function search($query = '')
    {
        return Livro::query()
            ->where('titulo', 'like', "%{$query}%")
            ->orWhere('descricao', 'like', "%{$query}%")
            ->orWhere('autor', 'like', "%{$query}%")
            ->get();
    }
}
