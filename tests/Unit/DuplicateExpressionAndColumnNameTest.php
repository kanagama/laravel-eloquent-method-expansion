<?php

namespace Kanagama\EloquentExpansion\Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Kanagama\EloquentExpansion\Tests\Models\Product;
use Kanagama\EloquentExpansion\Tests\TestCase;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class DuplicateExpressionAndColumnNameTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var Product
     */
    private Product $product;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $product = new Product([
            'name'            => 'test1',
            'discontinued'    => 0,
            'sale_date_start' => '2022-06-15 00:00:00',
            'sale_date_end'   => '2022-09-25 00:00:00',
            'date'            => '2022-05-21 00:00:00',
            'created_at'      => '2022-01-01 00:00:00',
            'updated_at'      => '2022-01-01 00:00:00',
        ]);
        $product->save();

        /** @var Product */
        $this->product = app()->make(Product::class);
    }

    /**
     * @test
     */
    public function columNameの一部にexpressionが含まれていても正しいcolumnNameを取得できる()
    {
        /** @var Collection */
        $products = $this->product->whereSaleDateStartDate('2022-06-15')->get();

        $this->assertCount(1, $products);
    }

    /**
     * @test
     */
    public function columNameがexpressionと重複した名称でも正しいcolumnNameを取得できる()
    {
        /** @var Collection */
        $products = $this->product->whereDateDate('2022-05-21')->get();

        $this->assertCount(1, $products);
    }
}
