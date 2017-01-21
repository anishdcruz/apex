<?php

namespace App\Support;

use Illuminate\Validation\ValidationException;
use Validator;

trait PaginationOrderFilter {

    protected $operators = [
        'equal_to' => '=',
        'not_equal' => '<>',
        'less_than' => '<',
        'greater_than' => '>',
        'less_than_or_equal_to' => '<=',
        'greater_than_or_equal_to' => '>=',
        'in' => 'IN',
        'not_in' => 'NOT IN',
        'like' => 'LIKE',
        'between' => 'BETWEEN'
    ];

    public function scopePaginationOrderFilter($query)
    {
        $request = app()->make('request');

        $v = Validator::make($request->all(), [
            'column' => 'required|in:'.implode(',', $this->filterFields),
            'direction' => 'required|in:asc,desc',
            'per_page' => 'required|integer|min:1',
            'search_column' => 'required|in:'.implode(',', $this->filterFields),
            'search_operator' => 'required|in:'.implode(',', array_keys($this->operators)),
            'search_query_1' => 'max:255',
            'search_query_2' => 'max:255'
        ]);

        if($v->fails()) {
            dd($v->messages());
            // throw new ValidationException($v->messages());
        }

        return $query
            ->orderBy($request->column, $request->direction)
            ->where(function($query) use ($request) {
                if($request->has('search_query_1')) {
                    if (strpos($request->search_column, ".") !== false) {
                        // filter a relation
                        list($relation, $relationColumn) = explode('.', $request->search_column);

                        $query->whereHas($relation, function($query) use ($relationColumn, $request) {
                            return $this->buildQuery(
                                $relationColumn,
                                $request->search_operator,
                                $request,
                                $query
                            );
                        });
                    } else {
                        return $this->buildQuery(
                            $request->search_column,
                            $request->search_operator,
                            $request,
                            $query
                        );
                    }
                }
            })
            ->paginate($request->per_page);
    }

    private function buildQuery($column, $operator, $request, $query)
    {
        switch ($operator) {
            case 'equal_to':
            case 'not_equal':
            case 'less_than':
            case 'greater_than':
            case 'less_than_or_equal_to':
            case 'greater_than_or_equal_to':
                $query->where($column, $this->operators[$operator], $request->search_query_1);
                break;
            case 'in':
                $query->whereIn($column, explode(',', $request->search_query_1));
                break;
            case 'not_in':
                $query->whereNotIn($column, explode(',', $request->search_query_1));
                break;
            case 'like':
                $query->where($column, 'like', '%'.$request->search_query_1.'%');
                break;
            case 'between':
                $query->whereBetween($column, [
                    $request->search_query_1,
                     $request->search_query_2
                ]);
                break;
            default:
                throw new Exception('Invalid Search operator', 1);
                break;
        }
        return $query;
    }
}