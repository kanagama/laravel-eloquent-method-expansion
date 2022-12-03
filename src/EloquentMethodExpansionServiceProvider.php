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
            return $this->where($column, 'NOT LIKE', '%' . $value, $boolean);
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

        // whereColumnGt
        // whereColumnGte
        // whereColumnLt
        // whereColumnLte
    }
}
