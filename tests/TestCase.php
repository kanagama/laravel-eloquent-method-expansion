<?php

namespace Kanagama\EloquentExpansion\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kanagama\EloquentExpansion\EloquentMethodExpansionServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    // public function setUp(): void
    // {
    //     parent::setUp();

    //     Schema::create('areas', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->boolean('view_flg')->nullable();
    //         $table->timestamps();
    //     });

    //     Schema::create('products', function (Blueprint $table) {
    //         $table->increments('id');
    //         $table->string('name');
    //         $table->boolean('discontinued');
    //         $table->dateTime('sale_date_start', 6);
    //         $table->dateTime('sale_date_end', 6);
    //         $table->dateTime('date', 6);
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * @return void
    //  */
    // public function tearDown(): void
    // {
    //     Schema::dropIfExists('areas');
    //     Schema::dropIfExists('products');
    // }

    /**
     * @param  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            EloquentMethodExpansionServiceProvider::class,
        ];
    }
}
