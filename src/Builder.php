<?php

namespace Kanagama\EloquentExpansion;

use BadMethodCallException;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Support\Str;

class Builder extends BaseBuilder
{
    /**
     * 後方一致（順番大事）
     */
    private const BACKWORD_EXTENSION = [
        'ColumnGte', 'ColumnGt', 'ColumnLte', 'ColumnLt', 'Column',
        'DateGte', 'DateGt', 'DateLte', 'DateLt', 'Date',
        'YearGte', 'YearGt', 'YearLte', 'YearLt', 'Year',
        'MonthGte', 'MonthGt', 'MonthLte', 'MonthLt', 'Month',
        'DayGte', 'DayGt', 'DayLte', 'DayLt', 'Day',
        'TimeGte', 'TimeGt', 'TimeLte', 'TimeLt', 'Time',
        'NotEq', 'Eq',
        'NotLikePrefix', 'NotLikeBackword', 'NotLike',
        'LikePrefix', 'LikeBackword', 'Like',
        'NotIn', 'In',
        'Gte', 'Gt', 'Lte', 'Lt',
        'IsNotNull', 'IsNull',
        'NotBetween','Between',
        'NotExists', 'Exists',
    ];

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        $expression = $this->checkBackwordExpression($method);
        if (!$expression) {
            return parent::__call($method, $parameters);
        }

        // whereAllowEmpty prefix がついている、かつパラメータが空
        if (
            (str_starts_with($method, 'whereAllowEmpty') || str_starts_with($method, 'orWhereAllowEmpty'))
            &&
            $this->checkAllowEmpty($parameters)
        ) {
            return $this;
        }

        // where が先頭
        if (str_starts_with($method, 'where')) {
            $columnName = Str::snake(str_replace(['whereAllowEmpty', 'where', $expression,], '', $method));
            $method = 'where' . $expression;
        }
        // where が先頭
        if (str_starts_with($method, 'orWhere')) {
            $columnName = Str::snake(str_replace(['orWhereAllowEmpty', 'orWhere', $expression,], '', $method));
            $method = 'orWhere' . $expression;
        }

        // 既存メソッドであればそのまま実行する
        if (method_exists($this, $method)) {
            // if (in_array($method, ['whereColumn',])) {
            //     return $this->{$method}($columnName, $parameters[0]);
            // }
            $requestParameters = (count($parameters) === 1) ? $parameters[0] : $parameters;
            return $this->{$method}($columnName, $requestParameters);
        }

        if (!empty($columnName)) {
            array_unshift($parameters, $columnName);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @param  string  $method
     * @return string
     */
    private function checkBackwordExpression($method)
    {
        foreach (self::BACKWORD_EXTENSION as $expression) {
            if (str_ends_with($method, $expression)) {
                return $expression;
            }
        }

        return '';
    }

    /**
     * パラメータの空判定
     *
     * @param  array  $parameters
     * @return bool
     */
    private function checkAllowEmpty(array $parameters): bool
    {
        if (empty($parameters)) {
            return true;
        }

        foreach ($parameters as $parameter) {
            if (
                (is_array($parameter) && !empty($parameter))
                ||
                !is_null($parameter)
            ) {
                return false;
            }
        }

        return true;
    }
}
