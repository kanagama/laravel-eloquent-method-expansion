<?php

namespace Tests\Feature;

use Kanagama\EloquentExpansion\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class DuplicateExpressionAndColumnNameTest extends TestCase
{
    use DatabaseTransactions;

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
            'created_at'      => '2022-01-01 00:00:00',
            'updated_at'      => '2022-01-01 00:00:00',
        ]);
        $product->save();

        $this->product = app()->make(Product::class);
    }

    /**
     * @test
     */
    public function columNameの一部にexpressionが含まれていても正しいcolumnNameを取得できる()
    {
        $products = $this->product->whereSaleDateStartDate('2022-06-15')->get();

        $this->assertCount(1, $products);
    }
}
