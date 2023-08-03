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
     * @static
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
     * @static
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
            ($this->strStartsWith($method, 'whereAllowEmpty') || $this->strStartsWith($method, 'orWhereAllowEmpty'))
            &&
            $this->checkAllowEmpty($parameters)
        ) {
            // AllowEmpty オプションで null チェックはできない
            if ($this->strEndsWith($method, 'Null')) {
                throw new BadMethodCallException('No such method: ' . $method);
            }
            return $this;
        }

        if ($whereExpression) {
            if ($this->strStartsWith($method, 'where')) {
                $columnName = $this->getColumnName($method, $whereExpression, 'whereAllowEmpty', 'where');
                $method = 'where' . $whereExpression;
            }
            if ($this->strStartsWith($method, 'orWhere')) {
                $columnName = $this->getColumnName($method, $whereExpression, 'orWhereAllowEmpty', 'orWhere');
                $method = 'orWhere' . $whereExpression;
            }
        }
        if ($orderByExpression) {
            if ($this->strStartsWith($method, 'orderBy')) {
                $columnName = $this->getColumnName($method, $orderByExpression, 'orderBy');
                $method = 'orderBy' . $orderByExpression;
                $parameters += [
                    $orderByExpression,
                ];
            }
        }

        if (!empty($columnName)) {
            // 既存メソッドであればそのまま実行
            if (method_exists($this, $method)) {
                $requestParameters = (count($parameters) === 1)
                                        ? $parameters[0]
                                        : $parameters;
                return $this->{$method}($columnName, $requestParameters);
            }

            // where, orWhere が先頭の場合はカラム名をパラメータに追加
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
            if ($this->strEndsWith($method, $expression)) {
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
            if ($this->strEndsWith($method, $expression)) {
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

    /**
     * 前方一致 str_start_with() 代替
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @return bool
     *
     * @todo PHP7.4 で動作させるために作成
     */
    private function strStartsWith(
        string $haystack,
        string $needle
    ): bool {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * 後方一致 str_end_with() 代替
     *
     * @param  string  $haystack
     * @param  string  $needle
     * @return bool
     *
     * @todo PHP7.4 で動作させるために作成
     */
    private function strEndsWith(
        string $haystack,
        string $needle
    ): bool {
        return substr($haystack, -strlen($needle)) === $needle;
    }
}
