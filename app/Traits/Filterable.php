<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Summary of scopeSearch
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $columns
     * @return Builder
     */
    public function scopeSearch(Builder $query, array $columns): Builder
    {
        $term = request('search');
        if (!$term) return $query;

        $query->where(function (Builder $q) use ($columns, $term) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'LIKE', "%{$term}%");
            }
        });

        return $query;
    }

    /**
     * Summary of scopeFilter
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $column) {
            $value = request($key);
            if ($value === null) continue;

            if (is_array($value)) {
                $query->whereIn($column, $value);
            } else {
                $query->where($column, $value);
            }
        }

        return $query;
    }

    /**
     * Summary of scopeDate
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @return Builder
     */
    public function scopeDate(Builder $query, string $column = 'created_at'): Builder
    {
        $range = request('date');
        if (!$range) return $query;

        $range = str_replace('to', '-', $range);
        [$start, $end] = explode(' - ', $range) + [null, null];

        $start = $start ? Carbon::parse($start)->startOfDay() : null;
        $end   = $end   ? Carbon::parse($end)->endOfDay() : null;

        if ($start && $end) {
            $query->whereBetween($column, [$start, $end]);
        } elseif ($start) {
            $query->whereDate($column, $start);
        }

        return $query;
    }
}
