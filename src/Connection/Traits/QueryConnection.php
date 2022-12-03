<?php

namespace Kanagama\EloquentExpansion\Connection\Traits;

use Kanagama\EloquentExpansion\Builder as QueryBuilder;

trait QueryConnection
{
    /**
     * Get a new query builder instance.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return new QueryBuilder(
            $this, $this->getQueryGrammar(), $this->getPostProcessor()
        );
    }
}
