<?php

namespace Kanagama\EloquentExpansion;

use Illuminate\Support\Str;

/**
 * @autor k-nagmaa <k.nagama0632@gmail.com>
 */
trait MethodExpansion
{
    /**
     * 後方一致（順番大事）
     */
    protected array $backwordExpression = [
        'NotEq',
        'Eq',
        'NotLikePrefix',
        'NotLikeBackword',
        'NotLike',
        'LikePrefix',
        'LikeBackword',
        'Like',
        'NotIn',
        'In',
        'Gte',
        'Gt',
        'Lte',
        'Lt',
        'IsNotNull',
        'IsNull',
        'Between',
        'NotExists',
        'Exists',
    ];

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // スコープメソッドが存在していればそのまま流す
        if (method_exists((new self), 'scope' . ucfirst($method))) {
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
            $expression = $this->checkBackwordExpression($method);
            array_unshift($parameters, Str::snake(str_replace(['whereAllowEmpty', 'where', $expression,], '', $method)));
            if ($expression) {
                $method = 'where' . $expression;
            }
        }
        // where が先頭
        if (str_starts_with($method, 'orWhere')) {
            $expression = $this->checkBackwordExpression($method);
            array_unshift($parameters, Str::snake(str_replace(['orWhereAllowEmpty', 'orWhere', $expression,], '', $method)));
            if ($expression) {
                $method = 'orWhere' . $expression;
            }
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @param  string  $method
     * @return string
     */
    private function checkBackwordExpression($method)
    {
        foreach ($this->backwordExpression as $expression) {
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
