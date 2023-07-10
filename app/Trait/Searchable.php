<?php

namespace App\Trait;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch($query, $search, $columns = [], $operator = 'LIKE')
    {
        if (!empty($search)) {
            $query->where(function (Builder $query) use ($search, $columns, $operator) {
                foreach ($columns as $column) {
                    $query->orWhere($column, $operator, '%' . $search . '%');
                }
                foreach ($this->searchableRelations() as $relation => $columns) {
                    $query->orWhereHas($relation, function (Builder $query) use ($search, $columns, $operator) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, $operator, '%' . $search . '%');
                        }
                    });
                }
            });
        }

        return $query;
    }

    protected function searchableRelations()
    {
        return [];
    }
}
