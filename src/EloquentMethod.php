<?php

namespace Kanagama\EloquentExpansion;

/**
 * @author k-nagama <k.nagama@se-ec.co.jp>
 */
class EloquentMethod
{
    /**
     * @param  string|array  $column
     * @param  string  $boolean
     * @param  bool  $not
     * @return $this
     */
    public function whereIsNull($column, $boolean = 'and', $not = false)
    {
        return $this->whereNull($column, $boolean, $not);
    }
    /**
     * @param  string|array  $column
     * @return $this
     */
    public function orWhereIsNull($column)
    {
        return $this->whereNull($column, 'or', false);
    }
    /**
     * @param  string|array  $column
     * @param  string  $boolean
     * @return $this
     */
    public function whereIsNotNull($column, $boolean = 'and')
    {
        return $this->whereNotNull($column, $boolean);
    }
    /**
     * @param  string|array  $column
     * @return $this
     */
    public function orWhereIsNotNull($column)
    {
        return $this->whereNotNull($column, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereEq($column, $value, $boolean = 'and')
    {
        return $this->where($column, '=', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereEq($column, $value)
    {
        return $this->where($column, '=', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotEq($column, $value, $boolean = 'and')
    {
        return $this->where($column, '<>', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereNotEq($column, $value)
    {
        return $this->where($column, '<>', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereGt($column, $value, $boolean = 'and')
    {
        return $this->where($column, '>', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereGt($column, $value)
    {
        return $this->where($column, '>', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereGte($column, $value, $boolean = 'and')
    {
        return $this->where($column, '>=', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereGte($column, $value)
    {
        return $this->where($column, '>=', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereLt($column, $value, $boolean = 'and')
    {
        return $this->where($column, '<', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereLt($column, $value)
    {
        return $this->where($column, '<', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereLte($column, $value, $boolean = 'and')
    {
        return $this->where($column, '<=', $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereLte($column, $value)
    {
        return $this->where($column, '<=', $value, 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereLike($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'LIKE', '%' . $value . '%', $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereLike($column, $value)
    {
        return $this->where($column, 'LIKE', '%' . $value . '%', 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotLike($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'NOT LIKE', '%' . $value . '%', $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereNotLike($column, $value)
    {
        return $this->where($column, 'NOT LIKE', '%' . $value . '%', 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereLikePrefix($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'LIKE', $value . '%', $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereLikePrefix($column, $value)
    {
        return $this->where($column, 'LIKE', $value . '%', 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotLikePrefix($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'NOT LIKE', $value . '%', $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereNotLikePrefix($column, $value)
    {
        return $this->where($column, 'NOT LIKE', $value . '%', 'or');
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereLikeBackword($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'NOT LIKE', '%' . $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereLikeBackword($column, $value)
    {
        return $this->where($column, 'NOT LIKE', '%' . $value);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function whereNotLikeBackword($column, $value, $boolean = 'and')
    {
        return $this->where($column, 'NOT LIKE', '%' . $value, $boolean);
    }
    /**
     * @param  string  $column
     * @param  mixed  $value
     * @return $this
     */
    public function orWhereNotLikeBackword($column, $value)
    {
        return $this->where($column, 'NOT LIKE', '%' . $value, 'or');
    }
}