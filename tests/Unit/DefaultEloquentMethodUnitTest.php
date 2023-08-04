<?php

namespace Kanagama\EloquentExpansion\Tests\Unit;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\LazyCollection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Kanagama\EloquentExpansion\Tests\Models\Area;
use Kanagama\EloquentExpansion\Tests\Models\City;
use Kanagama\EloquentExpansion\Tests\Models\Prefecture;
use Kanagama\EloquentExpansion\Tests\TestCase;

/**
 * 他のクエリビルダメソッドが正常に動作することを確認する
 *
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class DefaultEloquentMethodUnitTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var Area
     */
    private Area $area;

    /**
     * @var Prefecture
     */
    private Prefecture $prefecture;

    /**
     *
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

        Prefecture::insert([
            'id'         => 1,
            'name'       => '北海道',
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),
        ]);

        City::insert([
            'id'            => 1,
            'prefecture_id' => 1,
            'name'          => '札幌',
            'created_at'    => CarbonImmutable::now(),
            'updated_at'    => CarbonImmutable::now(),
        ]);

        /** @var Area */
        $this->area = app()->make(Area::class);
        /** @var Prefecture */
        $this->prefecture = app()->make(Prefecture::class);
    }

    /**
     * @test
     * @group get
     */
    public function getMethod()
    {
        $this->assertInstanceOf(
            EloquentCollection::class,
            $this->area->get()
        );
    }

    /**
     * @test
     * @group first
     */
    public function firstMethd()
    {
        $this->assertInstanceOf(
            Area::class,
            $this->area->first()
        );
    }

    /**
     * @test
     * @group where
     */
    public function where()
    {
        $area = $this->area->where([
            'name' => '知念岬',
        ])
        ->first();

        $this->assertInstanceOf(
            Area::class,
            $area
        );
    }

    /**
     * @test
     * @group value
     */
    public function value()
    {
        $this->assertNotEmpty(
            $this->area->value('name')
        );
    }

    /**
     * @test
     * @group find
     */
    public function find()
    {
        /** @var Area */
        $area = $this->area->first();

        $this->assertInstanceOf(
            Area::class,
            $this->area->find($area->id)
        );
    }

    /**
     * @test
     * @group pluck
     * @return SupportCollection
     */
    public function pluck(): SupportCollection
    {
        $areas = $this->area->pluck('name');
        $this->assertInstanceOf(
            SupportCollection::class,
            $areas
        );

        foreach ($areas as $name) {
            $this->assertNotEmpty($name);
        }

        return $areas;
    }

    /**
     * @test
     * @group pluck
     * @depends pluck
     * @param  SupportCollection  $areas
     */
    public function pluckで値が取得できる(SupportCollection $areas)
    {
        foreach ($areas as $name) {
            $this->assertNotEmpty($name);
        }
    }

    /**
     * 正常に2件ずつ分割できている
     *
     * @test
     * @group chunk
     */
    public function chunk()
    {
        $this->area->chunk(2, function ($areas) {
            $this->assertCount(
                2,
                $areas
            );
        });
    }

    /**
     * @test
     * @group lazy
     */
    public function lazy()
    {
        $this->assertInstanceOf(
            LazyCollection::class,
            $this->area->lazy()
        );
    }

    /**
     * @test
     * @group count
     */
    public function countMethod()
    {
        $this->assertEquals(
            4,
            $this->area->count()
        );
    }

    /**
     * @test
     * @group max
     */
    public function maxMethod()
    {
        $this->assertEquals(
            2,
            $this->area->max('view_flg')
        );
    }

    /**
     * @test
     * @group min
     */
    public function minMethod()
    {
        $this->assertEquals(
            0,
            $this->area->min('view_flg')
        );
    }

    /**
     * @test
     * @group avg
     */
    public function avgMethod()
    {
        $this->assertEquals(
            1,
            $this->area->avg('view_flg')
        );
    }

    /**
     * @test
     * @group sum
     */
    public function sumMethod()
    {
        $this->assertEquals(
            3,
            $this->area->sum('view_flg')
        );
    }

    /**
     * @test
     * @group exists
     */
    public function exists()
    {
        $this->assertTrue(
            $this->area->where('name', 'おもろまち')->exists()
        );
    }

    /**
     * @test
     * @group doesntExist
     */
    public function doesntExist()
    {
        $this->assertFalse(
            $this->area->where('name', 'おもろまち')->doesntExist()
        );
    }

    /**
     * id のみ絞り込める
     *
     * @test
     * @group select
     */
    public function select()
    {
        /** @var EloquentCollection */
        $areas = $this->area->select(['id',])->get();
        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->id);

            $this->assertNull($area->name);
            $this->assertNull($area->view_flg);
            $this->assertNull($area->created_at);
            $this->assertNull($area->updated_at);
        }
    }

    /**
     * addSelect が正常に動作する
     *
     * @test
     * @group addSelect
     */
    public function addSelect()
    {
        /** @var Builder */
        $query = $this->area->select(['id',]);
        $query->addSelect(['name',]);

        /** @var EloquentCollection */
        $areas = $query->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->id);
            $this->assertNotNull($area->name);

            $this->assertNull($area->view_flg);
            $this->assertNull($area->created_at);
            $this->assertNull($area->updated_at);
        }
    }

    /**
     * @test
     * @group selectRaw
     * @return Area
     */
    public function selectRaw(): Area
    {
        /** @var Area */
        $area = $this->area->selectRaw('count(*) as count')->first();
        $this->assertInstanceOf(
            Area::class,
            $area
        );

        return $area;
    }

    /**
     * @test
     * @group selectRaw
     * @depends selectRaw
     * @param  Area  $area
     */
    public function selectRawで正常なselect結果が取得できる(Area $area)
    {
        $this->assertNotEmpty($area->count);
    }

    /**
     * @test
     * @group whereRaw
     * @return EloquentCollection
     */
    public function whereRaw()
    {
        $areas = $this->area->whereRaw('view_flg = 1')->get();
        $this->assertInstanceOf(
            EloquentCollection::class,
            $areas
        );

        return $areas;
    }

    /**
     * @test
     * @group whereRaw
     * @depends whereRaw
     * @param  EloquentCollection  $areas
     */
    public function whereRawで正常に絞り込みが行われる(EloquentCollection $areas)
    {
        /** @var Area */
        foreach ($areas as $area) {
            $this->assertEquals(
                1,
                $area->view_flg
            );
        }
    }

    /**
     * @test
     * @group orWhereRaw
     * @return EloquentCollection
     */
    public function orWhereRaw(): EloquentCollection
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->whereRaw('view_flg = 1')
            ->orWhereRaw('view_flg = 0')
            ->get();

        $this->assertInstanceOf(
            EloquentCollection::class,
            $areas
        );

        return $areas;
    }

    /**
     * @test
     * @group orWhereRaw
     * @depends orWhereRaw
     * @param  EloquentCollection  $areas
     */
    public function orWhereRawで正常に絞り込みが行われる(EloquentCollection $areas)
    {
        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                in_array($area->view_flg, [0, 1,], true)
            );
        }
    }

    /**
     * @test
     * @group havingRaw
     * @return EloquentCollection
     */
    public function havingRaw(): EloquentCollection
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->select('view_flg')
            ->groupBy('view_flg')
            ->havingRaw('view_flg > 0')
            ->get();

        $this->assertInstanceOf(
            EloquentCollection::class,
            $areas
        );

        return $areas;
    }

    /**
     * @test
     * @group havingRaw
     * @depends havingRaw
     * @param  EloquentCollection
     */
    public function havingRawで正常に絞り込める(EloquentCollection $areas)
    {
        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                in_array($area->view_flg, [1, 2,], true)
            );
        }
    }

    /**
     * @test
     * @group orHavingRaw
     * @return EloquentCollection
     */
    public function orHavingRaw(): EloquentCollection
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->select('view_flg')
            ->groupBy('view_flg')
            ->havingRaw('view_flg = 0')
            ->orHavingRaw('view_flg = 1')
            ->get();

        $this->assertInstanceOf(
            EloquentCollection::class,
            $areas
        );

        return $areas;
    }

    /**
     * @test
     * @group orHavingRaw
     * @depends orHavingRaw
     * @param  EloquentCollection  $areas
     */
    public function orHavingRawで正常に絞り込める(EloquentCollection $areas)
    {
        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                in_array($area->view_flg, [1, 0,], true)
            );
        }
    }

    /**
     * @test
     * @group join
     */
    public function join()
    {
        /** @var EloquentCollection */
        $prefectures = $this->prefecture
            ->select([
                'cities.name as city_name',
            ])
            ->join('cities', 'prefectures.id', '=', 'cities.id')
            ->get();

        foreach ($prefectures as $prefecture) {
            $this->assertNotEmpty($prefecture->city_name);
        }
    }

    /**
     * @test
     * @group leftJoin
     */
    public function leftJoin()
    {
        /** @var EloquentCollection */
        $prefectures = $this->prefecture
            ->select([
                'cities.name as city_name',
            ])
            ->leftJoin('cities', 'prefectures.id', '=', 'cities.id')
            ->get();

        foreach ($prefectures as $prefecture) {
            $this->assertNotNull($prefecture->city_name);
        }
    }

    /**
     * @test
     * @group rightJoin
     */
    public function rightJoin()
    {
        /** @var EloquentCollection */
        $prefectures = $this->prefecture
            ->select([
                'cities.name as city_name',
            ])
            ->rightJoin('cities', 'prefectures.id', '=', 'cities.id')
            ->get();

        foreach ($prefectures as $prefecture) {
            $this->assertNotEmpty($prefecture->city_name);
        }
    }

    /**
     * @group crossJoin
     */
    public function crossJoin()
    {

    }

    /**
     * @todo
     * @group joinSub
     */
    public function joinSub()
    {

    }

    /**
     * @group leftJoinSub
     */
    public function leftJoinSub()
    {

    }

    /**
     * @todo
     * @group rightJoinSub
     */
    public function rightJoinSub()
    {

    }

    /**
     * @todo
     * @group union
     */
    public function union()
    {

    }

    /**
     * @todo
     * @group orWhere
     */
    public function orWhere()
    {

    }

    /**
     * @todo
     * @group joinWhere
     */
    public function jsonWhere()
    {

    }

    /**
     * @todo
     * @group whereJsonContains
     */
    public function whereJsonContains()
    {

    }

    /**
     * @todo
     * @group whereJsonLength
     */
    public function whereJsonLength()
    {

    }

    /**
     * @todo
     * @group whereBetween
     */
    public function whereBetween()
    {

    }

    /**
     * @todo
     * @group orWhereBetween
     */
    public function orWhereBetween()
    {

    }

    /**
     * @todo
     * @group whereNotBetween
     */
    public function whereNotBeteen()
    {

    }

    /**
     * @todo
     * @group orWhereNotBetween
     */
    public function orWhereNotBetween()
    {

    }

    /**
     * @test
     * @group whereIn
     */
    public function whereIn()
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->whereIn('view_flg', [0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                in_array($area->view_flg, [0, 1,], true)
            );
        }
    }

    /**
     * @todo
     * @group orWhereIn
     */
    public function orWhereIn()
    {

    }

    /**
     * @test
     * @group whereNotIn
     */
    public function whereNotIn()
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->whereNotIn('view_flg', [0, 1,])
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertTrue(
                !in_array($area->view_flg, [0, 1,], true)
            );
        }
    }

    /**
     * @todo
     * @group orWhereNotIn
     */
    public function orWhereNotIn()
    {

    }

    /**
     * @test
     * @group whereNull
     */
    public function whereNull()
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->whereNull('view_flg')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNull($area->view_flg);
        }
    }

    /**
     * @todo
     * @group orWhereNull
     */
    public function orWhereNull()
    {

    }

    /**
     * @test
     * @group whereNotNull
     */
    public function whereNotNull()
    {
        /** @var EloquentCollection */
        $areas = $this->area
            ->whereNotNull('view_flg')
            ->get();

        /** @var Area */
        foreach ($areas as $area) {
            $this->assertNotNull($area->view_flg);
        }
    }

    /**
     * @todo
     * @group orWhereNotNull
     */
    public function orWhereNotNull()
    {

    }

    /**
     * @todo
     * @group whereDate
     */
    public function whereDate()
    {

    }

    /**
     * @todo
     * @group whereMonth
     */
    public function whereMonth()
    {

    }

    /**
     * @todo
     * @group whereDay
     */
    public function whereDay()
    {

    }

    /**
     * @todo
     * @group whereYear
     */
    public function whereYear()
    {

    }

    /**
     * @todo
     * @group whereTime
     */
    public function whereTime()
    {

    }

    /**
     * @todo
     * @group whereColumn
     */
    public function whereColumn()
    {

    }

    /**
     * @todo
     * @group orWhereColumn
     */
    public function orWhereColumn()
    {

    }

    /**
     * @todo
     * @group whereExists
     */
    public function whereExists()
    {

    }

    /**
     * @todo
     * @group subQueryWhere
     */
    public function サブクエリwhere()
    {

    }

    /**
     * @todo
     * @group orderBy
     */
    public function orderBy()
    {

    }

    /**
     * @todo
     * @group latest
     */
    public function latest()
    {

    }

    /**
     * @todo
     * @group oldest
     */
    public function oldest()
    {

    }

    /**
     * @todo
     * @group inRandomOrder
     */
    public function inRandomOrder()
    {

    }

    /**
     * @todo
     * @group reorder
     */
    public function reorder()
    {

    }

    /**
     * @todo
     * @gruop groupBy
     */
    public function groupBy()
    {

    }

    /**
     * @todo
     * @group having
     */
    public function having()
    {

    }

    /**
     * @todo
     * @group skip
     */
    public function skip()
    {

    }

    /**
     * @todo
     * @group take
     */
    public function take()
    {

    }

    /**
     * @todo
     * @group limit
     */
    public function limit()
    {

    }

    /**
     * @todo
     * @gropu offset
     */
    public function offset()
    {

    }

    /**
     * @todo
     * @group when
     */
    public function when()
    {

    }

    /**
     * @test
     * @group insert
     */
    public function insert()
    {
        $this->assertTrue(
            (bool) $this->area->insert([
                'name'       => 'testinsert',
                'view_flg'   => 1,
                'created_at' => CarbonImmutable::now(),
                'updated_at' => CarbonImmutable::now(),
            ])
        );
    }

    /**
     * @test
     * @group insert
     */
    public function insertで正常にレコードが追加される()
    {
        $this->insert();

        $area = $this->area->where('name', 'testinsert')->first();
        $this->assertInstanceOf(
            Area::class,
            $area
        );
    }

    /**
     * @test
     * @group update
     */
    public function update()
    {
        $result = (bool) $this->area
            ->where(['view_flg' => 1,])
            ->update(['view_flg' => 4,]);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @group update
     */
    public function updateでレコードが更新されている()
    {
        $this->update();

        /** @var Area */
        $area = $this->area
            ->where('view_flg', 4)
            ->first();

        $this->assertInstanceOf(
            Area::class,
            $area
        );
    }

    /**
     * @todo
     * @group undateOrInsert
     */
    public function updateOrInsert()
    {

    }

    /**
     * @test
     * @group increment
     */
    public function increment()
    {
        $this->area->where('view_flg', 1)->increment('view_flg', 2);

        $area = $this->area->where('view_flg', 3)->first();
        $this->assertInstanceOf(
            Area::class,
            $area
        );
    }

    /**
     * decrement で view_flg = 1 が2件になる
     *
     * @test
     * @group decrement
     */
    public function decrement()
    {
        $this->area->where('view_flg', 2)->decrement('view_flg', 1);

        /** @var EloquentCollection */
        $areas = $this->area->where('view_flg', 1)->get();
        $this->assertCount(
            2,
            $areas
        );
    }

    /**
     * @test
     * @group delete
     */
    public function deleteMethod()
    {
        $this->assertTrue(
            (bool) $this->area->whereNull('view_flg')->delete()
        );
    }

    /**
     * @test
     * @group delete
     */
    public function deleteで絞り込んだレコードが削除される()
    {
        $this->deleteMethod();

        $this->assertEquals(
            0,
            $this->area->whereNull('view_flg')->count()
        );
    }

    /**
     * @todo
     * @group lockForUpdate
     */
    public function lockForUpdate()
    {

    }

    /**
     * with()が正常に動作する
     *
     * @test
     * @group with
     */
    public function with()
    {
        $prefecture = $this->prefecture
            ->with('cities')
            ->first();

        foreach ($prefecture->cities as $city) {
            $this->assertInstanceOf(
                City::class,
                $city
            );
        }
    }

    /**
     * @test
     * @group load
     */
    public function load()
    {
        $prefecture = $this->prefecture
            ->load('cities')
            ->first();

        foreach ($prefecture->cities as $city) {
            $this->assertInstanceOf(
                City::class,
                $city
            );
        }
    }
}

