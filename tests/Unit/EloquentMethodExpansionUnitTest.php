<?php

namespace Kanagama\EloquentExpansion\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Kanagama\EloquentExpansion\Tests\Models\Area;
use Kanagama\EloquentExpansion\Tests\TestCase;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class EloquentMethodExpansionUnitTest extends TestCase
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

        /** @var Area */
        $area = new Area([
            'id'         => 1,
            'name'       => '那覇バスターミナル',
            'view_flg'   => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);
        $area->save();

        /** @var Area */
        $area = new Area([
            'id'         => 2,
            'name'       => 'おもろまち',
            'view_flg'   => 0,
            'created_at' => '2022-02-01 00:00:00',
            'updated_at' => '2022-02-01 02:00:00',
        ]);
        $area->save();

        /** @var Area */
        $area = new Area([
            'id'         => 3,
            'name'       => 'ひめゆり通り',
            'view_flg'   => 2,
            'created_at' => '2022-03-03 00:00:00',
            'updated_at' => '2022-03-03 03:00:00',
        ]);
        $area->save();

        /** @var Area */
        $area = new Area([
            'id'         => 4,
            'name'       => '知念岬',
            'view_flg'   => null,
            'created_at' => '2022-04-04 00:00:00',
            'updated_at' => '2022-04-04 04:00:00',
        ]);
        $area->save();

        /** @var Area */
        $this->area = app()->make(Area::class);
    }

    /**
     * 数値型がパラメータとして渡されても並び替えが可能
     *
     * @test
     */
    public function orderByField()
    {
        /** @var Collection */
        $areas = $this->area
            ->orderByViewFlgField([1, 0, 2,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
            break;
        }

        $this->assertCount(4, $areas);
    }

    /**
     * 文字列がパラメータとして渡されても並び替えが可能
     *
     * @test
     */
    public function orderByFieldString()
    {
        /** @var Collection */
        $areas = $this->area
            ->orderByNameField([
                'ひめゆり通り',
                '知念岬',
                '那覇バスターミナル',
                'おもろまち',
            ])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, 'ひめゆり通り');
            break;
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orderByAsc()
    {
        /** @var Collection */
        $areas = $this->area
            ->orderByViewFlgAsc()
            ->get();

        /** @var int|null */
        $beforeViewFlg = null;
        /** @var Area */
        foreach ($areas as $area) {
            if (!is_null($beforeViewFlg)) {
                $this->assertTrue(
                    is_null($area->view_flg)
                    ||
                    $area->view_flg > $beforeViewFlg
                );
            }
            $beforeViewFlg = $area->view_flg;
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orderByDesc()
    {
        /** @var Collection */
        $areas = $this->area
            ->orderByViewFlgDesc()
            ->get();

        /** @var int|null */
        $beforeViewFlg = null;
        /** @var Area */
        foreach ($areas as $area) {
            if (!is_null($beforeViewFlg)) {
                $this->assertTrue(
                    is_null($area->view_flg)
                    ||
                    $area->view_flg < $beforeViewFlg
                );
            }
            $beforeViewFlg = $area->view_flg;
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereRawDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereRaw('view_flg = 1')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereRawDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereRaw('view_flg = 1')
            ->orWhereRaw('view_flg = 0')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereColumnNameDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlg(1)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameEq('おもろまち')
            ->whereAllowEmptyViewFlgEq(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, 'おもろまち');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgEq(0)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgEq(1)
            ->orWhereAllowEmptyCreatedAtEq('2022-02-01')
            ->orWhereAllowEmptyNameFlgEq(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->view_flg === 1
                ||
                $area->created_at->format('Y-m-d') === '2022-02-01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgNotEq(1)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->view_flg, 1);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameNotEq('おもろまち')
            ->whereAllowEmptyViewFlgNotEq(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, 'おもろまち');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlg(1)
            ->orWhereViewFlgNotEq(0)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->view_flg, 0);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyNotEq()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgEq(1)
            ->orWhereAllowEmptyNameNotEq('おもろまち')
            ->orWhereAllowEmptyCreatedAtNotEq(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->view_flg === 1
                ||
                $area->name !== 'おもろまち'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereNullDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNull('view_flg')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNull($area->view_flg);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereIsNull()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNull($area->view_flg);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereIsNull()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgIsNull()
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->view_flg, 0);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotNullDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNotNull('view_flg')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->view_flg);
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereIsNotNull()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->view_flg);
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereIsNotNull()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgIsNotNull()
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->view_flg);
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtGt('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertGreaterThan('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtGt('2022-02-01 00:00:00')
            ->whereAllowEmptyUpdatedAtGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertGreaterThan('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtGt('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (is_null($area->view_flg) || $area->created_at > '2022-02-01 00:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtGt('2022-02-01 00:00:00')
            ->orWhereAllowEmptyUpdatedAtGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (is_null($area->view_flg) || $area->created_at > '2022-02-01 00:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtGte('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertGreaterThanOrEqual('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtGte('2022-02-01 00:00:00')
            ->whereAllowEmptyUpdatedAtGte('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertGreaterThanOrEqual('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtGte('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at >= '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtGte('2022-02-01 00:00:00')
            ->orWhereAllowEmptyUpdatedAtGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at >= '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtLt('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertLessThan('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtLt('2022-02-01 00:00:00')
            ->whereAllowEmptyUpdatedAtLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertLessThan('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtLt('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at < '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtLt('2022-02-01 00:00:00')
            ->orWhereAllowEmptyUpdatedAtLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at < '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtLte('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertLessThanOrEqual('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtLte('2022-02-01 00:00:00')
            ->whereAllowEmptyUpdatedAtLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertLessThanOrEqual('2022-02-01 00:00:00', $area->created_at);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtLte('2022-02-01 00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at <= '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtLte('2022-02-01 00:00:00')
            ->orWhereAllowEmptyUpdatedAtLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at <= '2022-02-01 00:00:00'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameLike('バス')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameLike('バス')
            ->whereAllowEmptyNameLike(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLike('バス')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameLike('バス')
            ->orWhereAllowEmptyNameLike(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameNotLike('バス')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameNotLike('バス')
            ->whereAllowEmptyNameNotLike(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLike('バス')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyNotLike()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameNotLike('バス')
            ->orWhereAllowEmptyNameNotLike(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameLikePrefix('那覇')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameLikePrefix('那覇')
            ->whereAllowEmptyNameLikePrefix(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLikePrefix('那覇')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameLikePrefix('那覇')
            ->orWhereAllowEmptyNameLikePrefix(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameNotLikePrefix('那覇')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameNotLikePrefix('那覇')
            ->whereAllowEmptyNameNotLikePrefix(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLikePrefix('那覇')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyNotLikePrefix()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameNotLikePrefix('那覇')
            ->orWhereAllowEmptyNameNotLikePrefix(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameLikeBackword('ターミナル')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameLikeBackword('ターミナル')
            ->whereAllowEmptyNameLikeBackword(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLikeBackword('ターミナル')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameLikeBackword('ターミナル')
            ->orWhereAllowEmptyNameLikeBackword(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name === '那覇バスターミナル'
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereNotLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameNotLikeBackword('ターミナル')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameNotLikeBackword('ターミナル')
            ->whereAllowEmptyNameNotLikeBackword(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotSame($area->name, '那覇バスターミナル');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLikeBackword('ターミナル')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyNotLikeBackword()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyNameNotLikeBackword('ターミナル')
            ->orWhereAllowEmptyNameNotLikeBackword(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->name !== '那覇バスターミナル'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereColumnDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereColumn('created_at', 'updated_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->eq($area->updated_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereColumn('created_at', 'updated_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->eq($area->updated_at)
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereColumn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtColumn('updated_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->eq($area->updated_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyColumn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtColumn('updated_at')
            ->whereAllowEmptyNameAtColumn(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->eq($area->updated_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtColumn('updated_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->eq($area->updated_at)
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyColumn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtColumn('updated_at')
            ->orWhereAllowEmptyUpdatedAtColumn(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->eq($area->updated_at)
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereColumnGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtColumnGt('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gt($area->created_at));
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyColumnGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtColumnGt('created_at')
            ->whereAllowEmptyNameColumnGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gt($area->created_at));
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereUpdatedAtColumnGt('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->updated_at->gt($area->created_at)
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyColumnGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyUpdatedAtColumnGt('created_at')
            ->orWhereAllowEmptyCreatedAtColumnGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->updated_at->gt($area->created_at)
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereColumnGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtColumnGte('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gte($area->created_at));
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyColumnGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtColumnGte('created_at')
            ->whereAllowEmptyCreatedAtColumnGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gte($area->created_at));
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnGte('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->updated_at->gte($area->created_at)
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyColumnGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtColumnGte('created_at')
            ->orWhereAllowEmptyCreatedAtColumnGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->updated_at->gte($area->created_at)
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     * @todo
     */
    public function whereColumnLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtColumnLt('created_at')
            ->get();

        $this->assertCount(0, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyColumnLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtColumnLt('created_at')
            ->whereAllowEmptyCreatedAtColumnLt(null)
            ->get();

        $this->assertCount(0, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnLt('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) && $area->created_at->lt($area->updated_at)
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyColumnLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtColumnLt('created_at')
            ->orWhereAllowEmptyCreatedAtColumnLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) && $area->created_at->lt($area->updated_at)
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereColumnLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtColumnLte('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gte($area->created_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyColumnLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtColumnLte('created_at')
            ->whereAllowEmptyCreatedAtColumnLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->updated_at->gte($area->created_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnLte('created_at')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->updated_at->gte($area->created_at)
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyColumnLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtColumnLte('created_at')
            ->orWhereAllowEmptyCreatedAtColumnLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->updated_at->gte($area->created_at)
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereBetweenDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereBetween('view_flg', [0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereBetween()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgBetween([0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyBetween()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgBetween([0, 1,])
            ->whereAllowEmptyNameBetween([])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereBetween()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgBetween([1, 2,])
            ->orWhereCreatedAtBetween(['2022-04-01', '2022-04-05',])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                in_array($area->view_flg, [1, 2,])
                ||
                (
                    $area->created_at->format('Y-m-d') >= '2022-04-01'
                    &&
                    $area->created_at->format('Y-m-d') <= '2022-04-05'
                )
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereNotBetweenDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNotBetween('view_flg', [0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereNotBetween()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgNotBetween([0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotBetween()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgNotBetween([0, 1,])
            ->whereAllowEmptyViewFlgNotBetween(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereInDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereIn('view_flg', [1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIn([1,2])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [1, 2,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgIn([1,2])
            ->whereAllowEmptyNameIn([])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [1, 2,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIn([1,])
            ->orWhereNameIn(['おもろまち',])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->view_flg === 1
                ||
                $area->name === 'おもろまち'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyNameIn(['おもろまち',])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg)
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereNotInDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNotIn('view_flg', [1,2])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [1,2,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereNotIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgNotIn([1,2])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [1,2,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyNotIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgNotIn([1,2])
            ->whereAllowEmptyNameNotIn([])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [1,2,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereNameEq('おもろまち')
            ->orWhereViewFlgNotIn([2,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->view_flg !== 2
                ||
                $area->name !== 'おもろまち'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyNotIn()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyNameEq('おもろまち')
            ->orWhereAllowEmptyViewFlgNotIn([2,])
            ->orWhereAllowEmptyIdNotIn([])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->view_flg !== 2
                ||
                $area->name !== 'おもろまち'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereDateDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereDate('created_at', '2021-01-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') === '2021-01-01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereDate()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDate('2021-01-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') === '2021-01-01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDate()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDate('2021-01-01')
            ->whereAllowEmptyCreatedAtDate(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') === '2021-01-01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereDate()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDate('2021-01-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') === '2021-01-01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDate()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDate('2021-01-01')
            ->orWhereAllowEmptyUpdatedAtDate(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') === '2021-01-01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereDateGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDateGt('2021-01-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') > '2021-01-01');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDateGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDateGt('2021-01-01')
            ->whereAllowEmptyUpdatedAtDateGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') > '2021-01-01');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereDateGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDateGt('2021-01-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->created_at->format('Y-m-d') > '2021-01-01'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDateGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyCreatedAtDateGt('2021-01-01')
            ->orWhereAllowEmptyUpdatedAtDateGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->created_at->format('Y-m-d') > '2021-01-01'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereDateGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDateGte('2022-03-03')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') >= '2022-03-03');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDateGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDateGte('2022-03-03')
            ->whereAllowEmptyUpdatedAtDateGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') >= '2022-03-03');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereDateGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDateGte('2022-03-03')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->created_at->format('Y-m-d') >= '2022-03-03'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDateGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyCreatedAtDateGte('2022-03-03')
            ->orWhereAllowEmptyUpdatedAtDateGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || $area->created_at->format('Y-m-d') >= '2022-03-03'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereDateLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDateLt('2022-02-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') < '2022-02-01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDateLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDateLt('2022-02-01')
            ->whereAllowEmptyUpdatedAtDateLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') < '2022-02-01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereDateLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDateLt('2022-02-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') < '2022-02-01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDateLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDateLt('2022-02-01')
            ->orWhereAllowEmptyUpdatedAtDateLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') < '2022-02-01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereDateLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDateLte('2022-02-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') <= '2022-02-01');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDateLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDateLte('2022-02-01')
            ->whereAllowEmptyUpdatedAtDateLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y-m-d') <= '2022-02-01');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereDateLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDateLte('2022-02-01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') <= '2022-02-01'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDateLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDateLte('2022-02-01')
            ->orWhereAllowEmptyUpdatedAtDateLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y-m-d') <= '2022-02-01'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereMonthDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereMonth('created_at', '01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('m') === '01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereMonth()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonth('01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('m') === '01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyMonth()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonth('01')
            ->whereAllowEmptyUpdatedAtMonth(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('m') === '01');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereMonth()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonth('01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('m') === '01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyMonth()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtMonth('01')
            ->orWhereAllowEmptyUpdatedAtMonth(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('m') === '01'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereMonthGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonthGt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') > (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyMonthGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonthGt('02')
            ->whereAllowEmptyUpdatedAtMonthGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') > (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereMonthGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthGt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') > (int) '02'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyMonthGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtMonthGt('02')
            ->orWhereAllowEmptyUpdatedAtMonthGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') > (int) '02'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereMonthGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonthGte('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') >= (int) '02');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyMonthGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonthGte('02')
            ->whereAllowEmptyUpdatedAtMonthGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') >= (int) '02');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereMonthGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthGte('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') >= (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyMonthGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtMonthGte('02')
            ->orWhereAllowEmptyUpdatedAtMonthGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') >= (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereMonthLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonthLt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') < (int) '02');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyMonthLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonthLt('02')
            ->whereAllowEmptyUpdatedAtMonthLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') < (int) '02');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereMonthLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthLt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') < (int) '02'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyMonthLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtMonthLt('02')
            ->orWhereAllowEmptyUpdatedAtMonthLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') < (int) '02'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereMonthLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonthLte('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') <= (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyMonthLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonthLte('02')
            ->whereAllowEmptyAtMonthLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('m') <= (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereMonthLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthLte('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') <= (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyMonthLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtMonthLte('02')
            ->orWhereAllowEmptyUpdatedAtMonthLte('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('m') <= (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereDayDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereDay('created_at', '01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('d') === '01');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereDay()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDay('01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('d') === '01');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDay()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDay('01')
            ->whereAllowEmptyUpdatedAtDay(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('d') === '01');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereDay()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDay('01')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('d') === '01'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDay()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDay('01')
            ->orWhereAllowEmptyUpdatedAtDay(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('d') === '01'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereDayGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDayGt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') > (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDayGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDayGt('02')
            ->whereAllowEmptyUpdatedAtDayGt(null)
            ->get();

        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') > (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereDayGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDayGt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || (int) $area->created_at->format('d') > (int) '02'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDayGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyCreatedAtDayGt('02')
            ->orWhereAllowEmptyUpdatedAtDayGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || (int) $area->created_at->format('d') > (int) '02'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereDayGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDayGte('04')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') >= (int) '04');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDayGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDayGte('04')
            ->whereAllowEmptyUpdatedAtDayGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') >= (int) '04');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereDayGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDayLte('02')
            ->orWhereCreatedAtDayGte('04')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (int) $area->created_at->format('d') <= (int) '02'
                ||
                (int) $area->created_at->format('d') >= (int) '04'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDayGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDayLte('02')
            ->orWhereAllowEmptyCreatedAtDayGte('04')
            ->orWhereAllowEmptyUpdatedAtDayGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (int) $area->created_at->format('d') <= (int) '02'
                ||
                (int) $area->created_at->format('d') >= (int) '04'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereDayLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDayLt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') < (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDayLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDayLt('02')
            ->whereAllowEmptyUpdatedAtDayLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') < (int) '02');
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereDayLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDayLt('02')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('d') < (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDayLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDayLt('02')
            ->orWhereAllowEmptyUpdatedAtDayLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('d') < (int) '02'
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereDayLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDayLte('03')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') <= (int) '03');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyDayLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDayLte('03')
            ->whereAllowEmptyUpdatedAtDayLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('d') <= (int) '03');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereDayLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDayLte('03')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('d') <= (int) '03'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyDayLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtDayLte('03')
            ->orWhereAllowEmptyUpdatedAtDayLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('d') <= (int) '03'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereYearDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereYear('created_at', '2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y') === '2021');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereYear()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtYear('2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y') === '2021');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyYear()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtYear('2021')
            ->whereAllowEmptyUpdatedAtYear(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('Y') === '2021');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereYear()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYear('2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y') === '2021'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyYear()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtYear('2021')
            ->orWhereAllowEmptyUpdatedAtYear(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('Y') === '2021'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereYearGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtYearGt('2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') > (int) '2021');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyYearGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtYearGt('2021')
            ->whereAllowEmptyUpdatedAtYearGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') > (int) '2021');
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereYearGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtYearGt('2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || (int) $area->created_at->format('Y') > (int) '2021'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyYearGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereAllowEmptyCreatedAtYearGt('2021')
            ->orWhereAllowEmptyUpdatedAtYearGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !is_null($area->view_flg) || (int) $area->created_at->format('Y') > (int) '2021'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereYearGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtYearGte('2021')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') >= (int) '2021');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyYearGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtYearGte('2021')
            ->whereAllowEmptyUpdatedAtYearGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') >= (int) '2021');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereYearGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtMonthLte('01')
            ->orWhereCreatedAtYearGte('2022')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (int) $area->created_at->format('m') <= (int) '01'
                ||
                (int) $area->created_at->format('Y') >= (int) '2021'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyYearGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtMonthLte('01')
            ->orWhereAllowEmptyCreatedAtYearGte('2022')
            ->orWhereAllowEmptyUpdatedAtYearGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                (int) $area->created_at->format('m') <= (int) '01'
                ||
                (int) $area->created_at->format('Y') >= (int) '2021'
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereYearLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtYearLt('2022')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') < (int) '2022');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyYearLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtYearLt('2022')
            ->whereAllowEmptyUpdatedAtYearLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') < (int) '2022');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereYearLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYearLt('2022')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('Y') < (int) '2022'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyYearLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtYearLt('2022')
            ->orWhereAllowEmptyUpdatedAtYearLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || (int) $area->created_at->format('Y') < (int) '2022'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereYearLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtYearLte('2022')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') <= (int) '2022');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyYearLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtYearLte('2022')
            ->whereAllowEmptyUpdatedAtYearLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') <= (int) '2022');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     * @todo assertがイマイチ
     */
    public function orWhereYearLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYearLte('2022')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') <= (int) '2022');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     * @todo assertがイマイチ
     */
    public function orWhereAllowEmptyYearLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyCreatedAtYearLte('2022')
            ->orWhereAllowEmptyUpdatedAtYearLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue((int) $area->created_at->format('Y') <= (int) '2022');
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereTimeDefault()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereTime('updated_at', '00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('H:i:s') === '00:00:00');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereTime()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtTime('00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('H:i:s') === '00:00:00');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyTime()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtTime('00:00:00')
            ->whereAllowEmptyUpdatedAtTime(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->format('H:i:s') === '00:00:00');
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereTime()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTime('00:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('H:i:s') === '00:00:00'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyTime()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtTime('00:00:00')
            ->orWhereAllowEmptyCreatedAtTime(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg) || $area->created_at->format('H:i:s') === '00:00:00'
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereTimeGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtTimeGt('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) > strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyTimeGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtTimeGt('02:00:00')
            ->whereAllowEmptyCreatedAtTimeGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) > strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereTimeGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDate('2021-01-01')
            ->orWhereUpdatedAtTimeGt('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->created_at->eq($area->updated_at)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) > strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyTimeGt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDate('2021-01-01')
            ->orWhereAllowEmptyUpdatedAtTimeGt('02:00:00')
            ->orWhereAllowEmptyCreatedAtTimeGt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->created_at->eq($area->updated_at)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) > strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereTimeGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtTimeGte('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) >= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyTimeGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtTimeGte('02:00:00')
            ->whereAllowEmptyCreatedAtTimeGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) >= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereTimeGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereCreatedAtDate('2021-01-01')
            ->orWhereUpdatedAtTimeGte('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->created_at->eq($area->updated_at)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) >= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyTimeGte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyCreatedAtDate('2021-01-01')
            ->orWhereAllowEmptyUpdatedAtTimeGte('02:00:00')
            ->orWhereAllowEmptyCreatedAtTimeGte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                $area->created_at->eq($area->updated_at)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) >= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(4, $areas);
    }

    /**
     * @test
     */
    public function whereTimeLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtTimeLt('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) < strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyTimeLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtTimeLt('02:00:00')
            ->whereAllowEmptyCreatedAtTimeLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) < strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereTimeLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTimeLt('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) < strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyTimeLt()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtTimeLt('02:00:00')
            ->orWhereAllowEmptyCreatedAtTimeLt(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) < strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereTimeLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereUpdatedAtTimeLte('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) <= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereAllowEmptyTimeLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyUpdatedAtTimeLte('02:00:00')
            ->whereAllowEmptyCreatedAtTimeLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) <= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereTimeLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTimeLte('02:00:00')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) <= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function orWhereAllowEmptyTimeLte()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereAllowEmptyUpdatedAtTimeLte('02:00:00')
            ->orWhereAllowEmptyCreatedAtTimeLte(null)
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) <= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }

    /**
     * @test
     */
    public function allowEmptyオプションにintの0を渡しても省略しない()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgEq(0)
            ->get();

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function allowEmptyオプションにstringの0を渡しても省略しない()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgEq('0')
            ->get();

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function allowEmptyオプションに空の配列を渡すとその条件を省略する()
    {
        /** @var Collection */
        $areas = $this->area
            ->whereAllowEmptyViewFlgEq('0')
            ->whereAllowEmptyNameIn([])
            ->get();

        $this->assertCount(1, $areas);
    }
}
