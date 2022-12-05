<?php

namespace Kanagama\EloquentExpansion;

use Kanagama\EloquentExpansion\Builder;
use Kanagama\EloquentExpansion\Connection\ConnectionFactory;
use Illuminate\Support\ServiceProvider;

/**
 * @author k.nagama <k.nagama@gmail.com>
 */
class EloquentMethodExpansionServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register(): void
    {
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
    }

    /**
     *
     */
    public function boot(): void
    {
        /**
         * ->whereIsNull($column, $boolean = 'and', $not = false)
         */
        Builder::macro('whereIsNull', function ($column, $boolean = 'and', $not = false): Builder {
            return $this->whereNull($column, $boolean, $not);
        });

        /**
         * ->orWhereIsNull($column)
         */
        Builder::macro('orWhereIsNull', function ($column): Builder {
            return $this->whereNull($column, 'or', false);
        });

        /**
         * ->whereIsNotNull($column, $boolean = 'and')
         */
        Builder::macro('whereIsNotNull', function ($column, $boolean = 'and'): Builder {
            return $this->whereNotNull($column, $boolean);
        });

        /**
         * ->orWhereIsNotNull($column)
         */
        Builder::macro('orWhereIsNotNull', function ($column): Builder {
            return $this->whereNotNull($column, 'or');
        });

        /**
         * ->whereEq($column, $value)
         */
        Builder::macro('whereEq', function ($column, $value): Builder {
            return $this->where($column, '=', $value);
        });

        /**
         * ->orWhereEq($column, $value)
         */
        Builder::macro('orWhereEq', function ($column, $value): Builder {
            return $this->where($column, '=', $value, 'or');
        });

        /**
         * ->whereNotEq($column, $value, $boolean = 'and')
         */
        Builder::macro('whereNotEq', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, '<>', $value, $boolean);
        });

        /**
         * ->orWhereNotEq($column, $value)
         */
        Builder::macro('orWhereNotEq', function ($column, $value): Builder {
            return $this->where($column, '<>', $value, 'or');
        });

        /**
         * ->whereGt($column, $value, $boolean = 'and')
         */
        Builder::macro('whereGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, '>', $value, $boolean);
        });

        /**
         * ->orWhereGt($column, $value)
         */
        Builder::macro('orWhereGt', function ($column, $value): Builder {
            return $this->where($column, '>', $value, 'or');
        });

        /**
         * ->whereGte($column, $value, $boolean = 'and')
         */
        Builder::macro('whereGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, '>=', $value, $boolean);
        });

        /**
         * ->orWhereGte($column, $value)
         */
        Builder::macro('orWhereGte', function ($column, $value): Builder {
            return $this->where($column, '>=', $value, 'or');
        });

        /**
         * ->whereLt($column, $value, $boolean = 'and')
         */
        Builder::macro('whereLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, '<', $value, $boolean);
        });

        /**
         * ->orWhereLg($column, $value)
         */
        Builder::macro('orWhereLt', function ($column, $value): Builder {
            return $this->where($column, '<', $value, 'or');
        });

        /**
         * ->whereLte($column, $value, $boolean = 'and')
         */
        Builder::macro('whereLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, '<=', $value, $boolean);
        });

        /**
         * ->orWhereLte($column, $value)
         */
        Builder::macro('orWhereLte', function ($column, $value): Builder {
            return $this->where($column, '<=', $value, 'or');
        });

        /**
         * ->whereLike($column, $value, $boolean = 'and')
         */
        Builder::macro('whereLike', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'LIKE', '%' . $value . '%', $boolean);
        });

        /**
         * ->orWhereLike($column, $value)
         */
        Builder::macro('orWhereLike', function ($column, $value): Builder {
            return $this->where($column, 'LIKE', '%' . $value . '%', 'or');
        });

        /**
         * ->whereNotLike($column, $value, $boolean = 'and')
         */
        Builder::macro('whereNotLike', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'NOT LIKE', '%' . $value . '%', $boolean);
        });

        /**
         * ->orWhereNotLike($column, $value)
         */
        Builder::macro('orWhereNotLike', function ($column, $value): Builder {
            return $this->where($column, 'NOT LIKE', '%' . $value . '%', 'or');
        });

        /**
         * ->whereLikePrefix($column, $value, $boolean = 'and')
         */
        Builder::macro('whereLikePrefix', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'LIKE', $value . '%', $boolean);
        });

        /**
         * ->orWhereLikePrefix($column, $value)
         */
        Builder::macro('orWhereLikePrefix', function ($column, $value): Builder {
            return $this->where($column, 'LIKE', $value . '%', 'or');
        });

        /**
         * ->whereNotLikePrefix($column, $value, $boolean = 'and)
         */
        Builder::macro('whereNotLikePrefix', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'NOT LIKE', $value . '%', $boolean);
        });

        /**
         * ->orWhereNotLikePrefix($column, $value)
         */
        Builder::macro('orWhereNotLikePrefix', function ($column, $value): Builder {
            return $this->where($column, 'NOT LIKE', $value . '%', 'or');
        });

        /**
         * ->whereLikeBackend($column, $value, $boolean = 'and')
         */
        Builder::macro('whereLikeBackword', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'LIKE', '%' . $value, $boolean);
        });

        /**
         * ->orWhereLikePrefix($column, $value)
         */
        Builder::macro('orWhereLikeBackword', function ($column, $value): Builder {
            return $this->where($column, 'NOT LIKE', '%' . $value);
        });

        /**
         * ->whereNotLikeBackword($column, $value, $boolean = 'and')
         */
        Builder::macro('whereNotLikeBackword', function ($column, $value, $boolean = 'and'): Builder {
            return $this->where($column, 'NOT LIKE', '%' . $value, $boolean);
        });

        /**
         * ->orWhereNotLikeBackword($column, $value)
         */
        Builder::macro('orWhereNotLikeBackword', function ($column, $value): Builder {
            return $this->where($column, 'NOT LIKE', '%' . $value, 'or');
        });

        /**
         * ->whereColumnGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereColumnGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereColumn($column, '>', $value, $boolean);
        });

        /**
         * ->orWhereColumnGt($column, $value)
         */
        Builder::macro('orWhereColumnGt', function ($column, $value): Builder {
            return $this->whereColumn($column, '>', $value, 'or');
        });

        /**
         * ->whereColumnGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereColumnGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereColumn($column, '>=', $value, $boolean);
        });

        /**
         * ->orWhereColumnGt($column, $value)
         */
        Builder::macro('orWhereColumnGte', function ($column, $value): Builder {
            return $this->whereColumn($column, '>=', $value, 'or');
        });

        /**
         * ->whereColumnGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereColumnLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereColumn($column, '<', $value, $boolean);
        });

        /**
         * ->orWhereColumnGt($column, $value)
         */
        Builder::macro('orWhereColumnLt', function ($column, $value): Builder {
            return $this->whereColumn($column, '<', $value, 'or');
        });

        /**
         * ->whereColumnGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereColumnLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereColumn($column, '<=', $value, $boolean);
        });

        /**
         * ->orWhereColumnGt($column, $value)
         */
        Builder::macro('orWhereColumnLte', function ($column, $value): Builder {
            return $this->whereColumn($column, '<=', $value, 'or');
        });

        /**
         * ->whereDateGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDateGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDate($column, '>', $value, $boolean);
        });

        /**
         * ->orWhereDateGt($column, $value)
         */
        Builder::macro('orWhereDateGt', function ($column, $value): Builder {
            return $this->whereDate($column, '>', $value, 'or');
        });

        /**
         * ->whereDateGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDateGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDate($column, '>=', $value, $boolean);
        });

        /**
         * ->orWhereDateGte($column, $value)
         */
        Builder::macro('orWhereDateGte', function ($column, $value): Builder {
            return $this->whereDate($column, '>=', $value, 'or');
        });

        /**
         * ->whereDateLt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDateLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDate($column, '<', $value, $boolean);
        });

        /**
         * ->orWhereDateLt($column, $value)
         */
        Builder::macro('orWhereDateLt', function ($column, $value): Builder {
            return $this->whereDate($column, '<', $value, 'or');
        });

        /**
         * ->whereDateLte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDateLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDate($column, '<=', $value, $boolean);
        });

        /**
         * ->orWhereDateLte($column, $value)
         */
        Builder::macro('orWhereDateLte', function ($column, $value): Builder {
            return $this->whereDate($column, '<=', $value, 'or');
        });

        /**
         * ->whereMonthGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereMonthGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereMonth($column, '>', $value, $boolean);
        });

        /**
         * ->orwhereMonthGt($column, $value)
         */
        Builder::macro('orWhereMonthGt', function ($column, $value): Builder {
            return $this->whereMonth($column, '>', $value, 'or');
        });

        /**
         * ->whereMonthGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereMonthGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereMonth($column, '>=', $value, $boolean);
        });

        /**
         * ->orwhereMonthGte($column, $value)
         */
        Builder::macro('orWhereMonthGte', function ($column, $value): Builder {
            return $this->whereMonth($column, '>=', $value, 'or');
        });

        /**
         * ->whereMonthLt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereMonthLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereMonth($column, '<', $value, $boolean);
        });

        /**
         * ->orwhereMonthLt($column, $value)
         */
        Builder::macro('orWhereMonthLt', function ($column, $value): Builder {
            return $this->whereMonth($column, '<', $value, 'or');
        });

        /**
         * ->whereMonthLte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereMonthLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereMonth($column, '<=', $value, $boolean);
        });

        /**
         * ->orwhereMonthLte($column, $value)
         */
        Builder::macro('orWhereMonthLte', function ($column, $value): Builder {
            return $this->whereMonth($column, '<=', $value, 'or');
        });

        /**
         * ->whereDayGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDayGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDay($column, '>', $value, $boolean);
        });

        /**
         * ->orwhereDayGt($column, $value)
         */
        Builder::macro('orWhereDayGt', function ($column, $value): Builder {
            return $this->whereDay($column, '>', $value, 'or');
        });

        /**
         * ->whereDayGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDayGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDay($column, '>=', $value, $boolean);
        });

        /**
         * ->orwhereDayGte($column, $value)
         */
        Builder::macro('orWhereDayGte', function ($column, $value): Builder {
            return $this->whereDay($column, '>=', $value, 'or');
        });

        /**
         * ->whereDayLt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDayLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDay($column, '<', $value, $boolean);
        });

        /**
         * ->orwhereDayLt($column, $value)
         */
        Builder::macro('orWhereDayLt', function ($column, $value): Builder {
            return $this->whereDay($column, '<', $value, 'or');
        });

        /**
         * ->whereDayLte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereDayLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereDay($column, '<=', $value, $boolean);
        });

        /**
         * ->orwhereDayLte($column, $value)
         */
        Builder::macro('orWhereDayLte', function ($column, $value): Builder {
            return $this->whereDay($column, '<=', $value, 'or');
        });

        /**
         * ->whereYearGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereYearGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereYear($column, '>', $value, $boolean);
        });

        /**
         * ->orwhereYearGt($column, $value)
         */
        Builder::macro('orWhereYearGt', function ($column, $value): Builder {
            return $this->whereYear($column, '>', $value, 'or');
        });

        /**
         * ->whereYearGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereYearGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereYear($column, '>=', $value, $boolean);
        });

        /**
         * ->orwhereYearGte($column, $value)
         */
        Builder::macro('orWhereYearGte', function ($column, $value): Builder {
            return $this->whereYear($column, '>=', $value, 'or');
        });

        /**
         * ->whereYearLt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereYearLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereYear($column, '<', $value, $boolean);
        });

        /**
         * ->orwhereYearLt($column, $value)
         */
        Builder::macro('orWhereYearLt', function ($column, $value): Builder {
            return $this->whereYear($column, '<', $value, 'or');
        });

        /**
         * ->whereYearLte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereYearLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereYear($column, '<=', $value, $boolean);
        });

        /**
         * ->orwhereYearLte($column, $value)
         */
        Builder::macro('orWhereYearLte', function ($column, $value): Builder {
            return $this->whereYear($column, '<=', $value, 'or');
        });

        /**
         * ->whereTimeGt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereTimeGt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereTime($column, '>', $value, $boolean);
        });

        /**
         * ->orwhereTimeGt($column, $value)
         */
        Builder::macro('orWhereTimeGt', function ($column, $value): Builder {
            return $this->whereTime($column, '>', $value, 'or');
        });

        /**
         * ->whereTimeGte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereTimeGte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereTime($column, '>=', $value, $boolean);
        });

        /**
         * ->orwhereTimeGte($column, $value)
         */
        Builder::macro('orWhereTimeGte', function ($column, $value): Builder {
            return $this->whereTime($column, '>=', $value, 'or');
        });

        /**
         * ->whereTimeLt($column, $value, $boolean = 'and)
         */
        Builder::macro('whereTimeLt', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereTime($column, '<', $value, $boolean);
        });

        /**
         * ->orwhereTimeLt($column, $value)
         */
        Builder::macro('orWhereTimeLt', function ($column, $value): Builder {
            return $this->whereTime($column, '<', $value, 'or');
        });

        /**
         * ->whereTimeLte($column, $value, $boolean = 'and)
         */
        Builder::macro('whereTimeLte', function ($column, $value, $boolean = 'and'): Builder {
            return $this->whereTime($column, '<=', $value, $boolean);
        });

        /**
         * ->orwhereTimeLte($column, $value)
         */
        Builder::macro('orWhereTimeLte', function ($column, $value): Builder {
            return $this->whereTime($column, '<=', $value, 'or');
        });

        /**
         * ->orderByAsc($column, $value)
         */
        Builder::macro('orderByAsc', function ($column): Builder {
            return $this->orderBy($column, 'asc');
        });

        /**
         * ->orderByDesc($column, $value)
         */
        Builder::macro('orderByDesc', function ($column): Builder {
            return $this->orderBy($column, 'desc');
        });

        /**
         * ->orderByFieldDesc(string $column, array $values)
         */
        Builder::macro('orderByField', function (string $column, array $values): Builder {
            // 文字列の場合はシングルコーテーションで囲む
            $quote = "'";
            foreach ($values as $value) {
                if (is_string($value)) {
                    $quote = "'";
                    break;
                }
            }

            return $this->orderByRaw("FIELD({$column}, {$quote}" . implode("{$quote},{$quote}", array_reverse($values)) . "') DESC");
        });
    }
}
