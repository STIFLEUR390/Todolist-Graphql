<?php

namespace App\Trait;

use InvalidArgumentException;

trait SearchWithRelation
{
    public function globalSearch($query, $model, $val, $operator = 'LIKE')
    {
        $item = new $model;
        $attributes = array_keys($item->getOriginal());
        $queries = $query;
        foreach ($attributes as $key => $attribute) {
            if (str_contains($attribute, '.')) {
                // Recherche dans une relation
                $relation = explode('.', $attribute)[0];
                $relatedModel = $item->$relation()->getRelated();
                $relatedAttributes = array_keys($relatedModel->getOriginal());
                $relatedAttribute = str_replace($relation . '.', '', $attribute);
                $queries = $key == 0 ? $this->rechercheParRelation($queries, $relation, $relatedAttributes, $relatedAttribute, $operator, $val) : $this->rechercheParRelationTwo($queries, $relation, $relatedAttributes, $relatedAttribute, $operator, $val);
            } else {
                // Search in the main table
                $queries = $key == 0 ? $this->rechercheParColon($queries, $attribute, $operator, $val) : $this->rechercheParColonTwo($queries, $attribute, $operator, $val);
            }
        }
        return $queries;
    }

    public function rechercheParColon($query, $nomColon, $operator, $value)
    {
        switch ($operator) {
            case '=':
            case '<>':
            case '!=':
            case '<':
            case '>':
            case '>=':
            case '<=':
                $query->where($nomColon, $operator, $value);
                break;
            case 'LIKE':
            case 'NOT LIKE':
                $value = '%' . $value . '%';
                $query->where($nomColon, $operator, $value);
                break;
            case 'IN':
                $value = explode(',', $value);
                $query->whereIn($nomColon, $value);
                break;
            case 'NOT IN':
                $value = explode(',', $value);
                $query->whereNotIn($nomColon, $value);
                break;
            case 'BETWEEN':
                $value = explode(',', $value);
                $query->whereBetween($nomColon, $value);
                break;
            case 'NOT BETWEEN':
                $value = explode(',', $value);
                $query->whereNotBetween($nomColon, $value);
                break;
            case 'IS NULL':
                $query->whereNull($nomColon);
                break;
            case 'IS NOT NULL':
                $query->whereNotNull($nomColon);
                break;
            default:
                throw new InvalidArgumentException('Unsupported comparison operator.');
        }

        return $query;
    }

    public function rechercheParColonTwo($query, $nomColon, $operator, $value)
    {
        switch ($operator) {
            case '=':
            case '<>':
            case '!=':
            case '<':
            case '>':
            case '>=':
            case '<=':
                $query->orWhere($nomColon, $operator, $value);
                break;
            case 'LIKE':
            case 'NOT LIKE':
                $value = '%' . $value . '%';
                $query->orWhere($nomColon, $operator, $value);
                break;
            case 'IN':
                $value = explode(',', $value);
                $query->orWhereIn($nomColon, $value);
                break;
            case 'NOT IN':
                $value = explode(',', $value);
                $query->orWhereNotIn($nomColon, $value);
                break;
            case 'BETWEEN':
                $value = explode(',', $value);
                $query->orWhereBetween($nomColon, $value);
                break;
            case 'NOT BETWEEN':
                $value = explode(',', $value);
                $query->orWhereNotBetween($nomColon, $value);
                break;
            case 'IS NULL':
                $query->orWhereNull($nomColon);
                break;
            case 'IS NOT NULL':
                $query->orWhereNotNull($nomColon);
                break;
            default:
                // Unsupported operator
                throw new InvalidArgumentException('Unsupported comparison operator.');
        }

        return $query;
    }

    public function rechercheParRelation($query, $relation, $relatedAttributes, $relatedAttribute, $operator, $value)
    {
        $query->whereHas($relation,function ($query) use ($relatedAttributes, $relatedAttribute, $operator, $value) {
            $this->rechercheParColon($query, $relatedAttribute, $operator, $value);
            foreach ($relatedAttributes as $attribute) {
                if ($attribute !== $relatedAttribute) {
                    $this->rechercheParColonTwo($query, $attribute, $operator, $value);
                }
            }
        });

        return $query;
    }

    public function rechercheParRelationTwo($query, $relation, $relatedAttributes, $relatedAttribute, $operator, $value)
    {
        $query->orWhereHas($relation, function ($query) use ($relatedAttributes, $relatedAttribute, $operator, $value) {
            $this->rechercheParColon($query, $relatedAttribute, $operator, $value);
            foreach ($relatedAttributes as $attribute) {
                if ($attribute !== $relatedAttribute) {
                    $this->rechercheParColonTwo($query, $attribute, $operator, $value);
                }
            }
        });

        return $query;
    }
}
