<?php

namespace App\GraphQL\Builders;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CustomQueryBuilder extends QueryBuilder
{
    public function __construct($model, $request, $allowedSorts = [], $allowedFilters = [], $allowedIncludes = [])
    {
        $req = is_array($request) ? $request = new Request($request) : $request;
        parent::__construct($model::query(), $request);

        $this->allowedSorts($allowedSorts)
            ->allowedFilters($allowedFilters)
            ->allowedIncludes($allowedIncludes);
    }
}
