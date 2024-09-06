<?php

namespace Kanagama\EloquentExpansion\Tests\Models\ValueObjects\Common;

/**
 * 公開フラグオブジェクト
 */
class ViewFlg
{
    /**
     * 公開中
     *
     * @static
     * @var int
     */
    private const SHOW = 1;

    /**
     * 準備中
     *
     * @static
     * @var int
     */
    private const PREP = 2;

    /**
     * 非公開
     *
     * @static
     * @var int
     */
    private const HIDE = 0;

    /**
     * @static
     * @return int
     */
    public static function getShow(): int
    {
        return self::SHOW;
    }

    /**
     * @static
     * @return int
     */
    public static function getPrep(): int
    {
        return self::PREP;
    }

    /**
     * @static
     * @return int
     */
    public static function getHide(): int
    {
        return self::HIDE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::getShow() => '公開中',
            self::getPrep() => '準備中',
            self::getHide() => '非公開',
        ];
    }
}