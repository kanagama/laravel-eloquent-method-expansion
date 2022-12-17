<?php

namespace Kanagama\EloquentExpansion;

use BadMethodCallException;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Support\Str;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class Builder extends BaseBuilder
{
    /**
     * where() 後方一致（順番大事）
     *
     * @var array
     */
    private const WHERE_BACKWORD_EXTENSION = [
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
     * orderBy 後方一致
     *
     * @var array
     */
    private const ORDER_BY_BACKWORD_EXTENSION = [
        'Asc', 'Desc', 'Field',
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
        $whereExpression = $this->checkWhereBackwordExpression($method);
        $orderByExpression = $this->checkOrderByBackwordExpression($method);
        if (!$whereExpression && !$orderByExpression) {
            return parent::__call($method, $parameters);
        }

        // whereAllowEmpty prefix がついている、かつパラメータが空
        if (
            (str_starts_with($method, 'whereAllowEmpty') || str_starts_with($method, 'orWhereAllowEmpty'))
            &&
            $this->checkAllowEmpty($parameters)
        ) {
            // AllowEmpty オプションで null チェックはできない
            if (str_ends_with($method, 'Null')) {
                throw new BadMethodCallException('No such method: ' . $method);
            }
            return $this;
        }

        if ($whereExpression) {
            if (str_starts_with($method, 'where')) {
                $columnName = $this->getColumnName($method, $whereExpression, 'whereAllowEmpty', 'where');
                $method = 'where' . $whereExpression;
            }
            if (str_starts_with($method, 'orWhere')) {
                $columnName = $this->getColumnName($method, $whereExpression, 'orWhereAllowEmpty', 'orWhere');
                $method = 'orWhere' . $whereExpression;
            }
        }
        if ($orderByExpression) {
            if (str_starts_with($method, 'orderBy')) {
                $columnName = $this->getColumnName($method, $orderByExpression, 'orderBy');
                $method = 'orderBy' . $orderByExpression;
                $parameters += [
                    $orderByExpression,
                ];
            }
        }

        // 既存メソッドであればそのまま実行
        if (method_exists($this, $method)) {
            $requestParameters = (count($parameters) === 1)
                                    ? $parameters[0]
                                    : $parameters;
            return $this->{$method}($columnName, $requestParameters);
        }

        // where, orWhere が先頭の場合はカラム名をパラメータに追加
        if (!empty($columnName)) {
            array_unshift($parameters, $columnName);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * メソッド名からカラム名を取得する
     *
     * @param  string  $method
     * @param  string  $extension
     * @return string
     */
    private function getColumnName($method, $extension, $prefix1, $prefix2 = '')
    {
        $backwordLength = strrpos($method, $extension);
        if ($backwordLength) {
            $method = substr($method, 0, $backwordLength);
        }

        $prefixLength = strpos($method, $prefix1);
        if ($prefixLength !== false) {
            $method = substr($method, strlen($prefix1), strlen($method));
        }

        if ($prefix2) {
            $prefixLength = strpos($method, $prefix2);
            if ($prefixLength !== false) {
                $method = substr($method, strlen($prefix2), strlen($method));
            }
        }

        return Str::snake($method);
    }

    /**
     * @param  string  $method
     * @return string
     */
    private function checkWhereBackwordExpression($method)
    {
        foreach (self::WHERE_BACKWORD_EXTENSION as $expression) {
            if (str_ends_with($method, $expression)) {
                return $expression;
            }
        }

        return '';
    }

    /**
     * @param  string  $method
     * @return string
     */
    private function checkOrderByBackwordExpression($method)
    {
        foreach (self::ORDER_BY_BACKWORD_EXTENSION as $expression) {
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
            if (!empty($parameter) || is_numeric($parameter)) {
                return false;
            }
        }

        return true;
    }
}
