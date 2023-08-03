<?php

namespace Kanagama\EloquentExpansion\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Kanagama\EloquentExpansion\Tests\Models\Area;
use Kanagama\EloquentExpansion\Tests\TestCase;

/**
 * @method void setUp()
 * @method void scopeメソッドと重複していてもエラーにならない()
 *
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class ScopeMethodDuplicateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var Area
     */
    private Area $area;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $area = new Area([
            'name'       => '那覇バスターミナル',
            'view_flg'   => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);
        $area->save();

        /** @var Area */
        $this->area = app()->make(Area::class);
    }

    /**
     * @test
     */
    public function scopeメソッドと重複していてもエラーにならない()
    {
        /** @var Area */
        $area = $this->area
            ->whereViewFlgIsNotNull()
            ->first();

        $this->assertNotNull($area);
        $this->assertNotNull($area->view_flg);
    }
}
