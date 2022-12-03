<?php

namespace Tests\Feature;

use App\Models\Area;
use Kanagama\EloquentExpansion\TestCase\Seeder\AreaSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class EloquentMethodExpansionUnitTest extends TestCase
{
    use DatabaseTransactions;

    private Area $area;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $area = new Area([
            'id'         => 1,
            'name'       => '那覇バスターミナル',
            'view_flg'   => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);
        $area->save();

        $area = new Area([
            'id'         => 2,
            'name'       => 'おもろまち',
            'view_flg'   => 0,
            'created_at' => '2022-02-01 00:00:00',
            'updated_at' => '2022-02-01 02:00:00',
        ]);
        $area->save();

        $area = new Area([
            'id'         => 3,
            'name'       => 'ひめゆり通り',
            'view_flg'   => 2,
            'created_at' => '2022-03-03 00:00:00',
            'updated_at' => '2022-03-03 03:00:00',
        ]);
        $area->save();

        $area = new Area([
            'id'         => 4,
            'name'       => '知念岬',
            'view_flg'   => null,
            'created_at' => '2022-04-04 00:00:00',
            'updated_at' => '2022-04-04 04:00:00',
        ]);
        $area->save();

        $this->area = app()->make(Area::class);
    }

    /**
     * @test
     */
    public function whereRawDefault()
    {
        $areas = $this->area->whereRaw('view_flg = 1')->get();
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereColumnNameDefault()
    {
        $areas = $this->area->whereViewFlg(1)->get();
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
        $areas = $this->area->whereViewFlgEq(1)->get();
        foreach ($areas as $area) {
            $this->assertSame($area->view_flg, 1);
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function orWhereEq()
    {
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgEq(0)
            ->get();

        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0,1,]));
        }

        $this->assertCount(2, $areas);
    }

   /**
     * @test
     */
    public function whereNotEq()
    {
        $areas = $this->area->whereViewFlgNotEq(1)->get();
        foreach ($areas as $area) {
            $this->assertNotSame($area->view_flg, 1);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function orWhereNotEq()
    {
        $areas = $this->area
            ->whereViewFlg(1)
            ->orWhereViewFlgNotEq(0)
            ->get();

        foreach ($areas as $area) {
            $this->assertNotSame($area->view_flg, 0);
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNullDefault()
    {
        $areas = $this->area->whereNull('view_flg')->get();
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
        $areas = $this->area->whereViewFlgIsNull()->get();
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
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgIsNull()
            ->get();

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
        $areas = $this->area->whereNotNull('view_flg')->get();
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
        $areas = $this->area->whereViewFlgIsNotNull()->get();
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
        $areas = $this->area
            ->whereViewFlgEq(1)
            ->orWhereViewFlgIsNotNull()
            ->get();

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
        $areas = $this->area->whereCreatedAtGt('2022-02-01 00:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtGt('2022-02-01 00:00:00')
            ->get();

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
        $areas = $this->area->whereCreatedAtGte('2022-02-01 00:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtGte('2022-02-01 00:00:00')
            ->get();

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
        $areas = $this->area->whereCreatedAtLt('2022-02-01 00:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtLt('2022-02-01 00:00:00')
            ->get();

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
        $areas = $this->area->whereCreatedAtLte('2022-02-01 00:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtLte('2022-02-01 00:00:00')
            ->get();

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
        $areas = $this->area->whereNameLike('バス')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLike('バス')
            ->get();

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
        $areas = $this->area->whereNameNotLike('バス')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLike('バス')
            ->get();

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
        $areas = $this->area->whereNameLikePrefix('那覇')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLikePrefix('那覇')
            ->get();

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
        $areas = $this->area->whereNameNotLikePrefix('那覇')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLikePrefix('那覇')
            ->get();

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
        $areas = $this->area->whereNameLikeBackword('ターミナル')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameLikeBackword('ターミナル')
            ->get();

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
        $areas = $this->area->whereNameNotLikeBackword('ターミナル')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereNameNotLikeBackword('ターミナル')
            ->get();

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
        $areas = $this->area->whereColumn('created_at', 'updated_at')->get();
        foreach ($areas as $area) {
            $this->assertTrue($area->created_at->eq($area->updated_at));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereColumn()
    {
        $areas = $this->area->whereCreatedAtColumn('updated_at')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereColumn('created_at', 'updated_at')
            ->get();

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
    public function orWhereColumn()
    {
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtColumn('updated_at')
            ->get();

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
        $areas = $this->area->whereUpdatedAtColumnGt('created_at')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereUpdatedAtColumnGt('created_at')
            ->get();

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
        $areas = $this->area->whereUpdatedAtColumnGte('created_at')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnGte('created_at')
            ->get();

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
    public function whereColumnLt()
    {
        $areas = $this->area->whereUpdatedAtColumnLt('created_at')->get();
        $this->assertCount(0, $areas);
    }

    /**
     * @test
     */
    public function orWhereColumnLt()
    {
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnLt('created_at')
            ->get();

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
    public function orWhereColumnLte()
    {
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtColumnLte('created_at')
            ->get();

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
        $areas = $this->area->whereBetween('view_flg', [0, 1,])->get();
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
        $areas = $this->area->whereViewFlgBetween([0, 1,])->get();
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [0, 1,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotBetweenDefault()
    {
        $areas = $this->area->whereNotBetween('view_flg', [0, 1,])->get();
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
        $areas = $this->area
            ->whereViewFlgNotBetween([0, 1,])
            ->get();

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
        $areas = $this->area->whereIn('view_flg', [1,])->get();
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
        $areas = $this->area->whereViewFlgIn([1,2])->get();
        foreach ($areas as $area) {
            $this->assertTrue(in_array($area->view_flg, [1, 2,]));
        }

        $this->assertCount(2, $areas);
    }

    /**
     * @test
     */
    public function whereNotInDefault()
    {
        $areas = $this->area->whereNotIn('view_flg', [1,2])->get();
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
        $areas = $this->area->whereViewFlgNotIn([1,2])->get();
        foreach ($areas as $area) {
            $this->assertTrue(!in_array($area->view_flg, [1,2,]));
        }

        $this->assertCount(1, $areas);
    }

    /**
     * @test
     */
    public function whereDateDefault()
    {
        $areas = $this->area->whereDate('created_at', '2021-01-01')->get();
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
        $areas = $this->area->whereCreatedAtDate('2021-01-01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDate('2021-01-01')
            ->get();

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
        $areas = $this->area->whereCreatedAtDateGt('2021-01-01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDateGt('2021-01-01')
            ->get();

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
        $areas = $this->area->whereCreatedAtDateGte('2022-03-03')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDateGte('2022-03-03')
            ->get();

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
        $areas = $this->area->whereCreatedAtDateLt('2022-02-01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDateLt('2022-02-01')
            ->get();

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
        $areas = $this->area->whereCreatedAtDateLte('2022-02-01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDateLte('2022-02-01')
            ->get();

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
        $areas = $this->area->whereMonth('created_at', '01')->get();
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
        $areas = $this->area->whereCreatedAtMonth('01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonth('01')
            ->get();

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
        $areas = $this->area->whereCreatedAtMonthGt('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthGt('02')
            ->get();

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
        $areas = $this->area->whereCreatedAtMonthGte('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthGte('02')
            ->get();

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
        $areas = $this->area->whereCreatedAtMonthLt('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthLt('02')
            ->get();

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
        $areas = $this->area->whereCreatedAtMonthLte('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtMonthLte('02')
            ->get();

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
        $areas = $this->area->whereDay('created_at', '01')->get();
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
        $areas = $this->area->whereCreatedAtDay('01')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDay('01')
            ->get();

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
        $areas = $this->area->whereCreatedAtDayGt('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtDayGt('02')
            ->get();

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
        $areas = $this->area->whereCreatedAtDayGte('04')->get();
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
        $areas = $this->area
            ->whereCreatedAtDayLte('02')
            ->orWhereCreatedAtDayGte('04')
            ->get();

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
        $areas = $this->area->whereCreatedAtDayLt('02')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDayLt('02')
            ->get();

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
        $areas = $this->area->whereCreatedAtDayLte('03')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtDayLte('03')
            ->get();

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
        $areas = $this->area->whereYear('created_at', '2021')->get();
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
        $areas = $this->area->whereCreatedAtYear('2021')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYear('2021')
            ->get();

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
        $areas = $this->area->whereCreatedAtYearGt('2021')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNotNull()
            ->orWhereCreatedAtYearGt('2021')
            ->get();

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
        $areas = $this->area->whereCreatedAtYearGte('2021')->get();
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
        $areas = $this->area
            ->whereCreatedAtMonthLte('01')
            ->orWhereCreatedAtYearGte('2022')
            ->get();

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
        $areas = $this->area->whereCreatedAtYearLt('2022')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYearLt('2022')
            ->get();

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
        $areas = $this->area->whereCreatedAtYearLte('2022')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereCreatedAtYearLte('2022')
            ->get();

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
        $areas = $this->area->whereTime('updated_at', '00:00:00')->get();
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
        $areas = $this->area->whereUpdatedAtTime('00:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTime('00:00:00')
            ->get();

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
        $areas = $this->area->whereUpdatedAtTimeGt('02:00:00')->get();
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
        $areas = $this->area
            ->whereCreatedAtDate('2021-01-01')
            ->orWhereUpdatedAtTimeGt('02:00:00')
            ->get();

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
        $areas = $this->area
            ->whereCreatedAtDate('2021-01-01')
            ->orWhereUpdatedAtTimeGte('02:00:00')
            ->get();

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
        $areas = $this->area->whereUpdatedAtTimeLt('02:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTimeLt('02:00:00')
            ->get();

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
        $areas = $this->area->whereUpdatedAtTimeLte('02:00:00')->get();
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
        $areas = $this->area
            ->whereViewFlgIsNull()
            ->orWhereUpdatedAtTimeLte('02:00:00')
            ->get();

        foreach ($areas as $area) {
            $this->assertTrue(
                is_null($area->view_flg)
                ||
                strtotime(date('Y-m-d') . ' ' . $area->updated_at->format('H:i:s')) <= strtotime(date('Y-m-d') . ' 02:00:00')
            );
        }

        $this->assertCount(3, $areas);
    }
}
