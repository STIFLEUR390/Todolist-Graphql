<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;


trait Paginatable
{
    public function scopePaginateRequest($query, $request, $perPage = 10)
    {
        $perPage = $request->query('perPage', $perPage);
        $page = $request->query('page', 1);
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function scopePaginate($query, $perPage = 10, $page = 1)
    {
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
