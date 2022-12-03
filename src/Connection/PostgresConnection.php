<?php

namespace Kanagama\EloquentExpansion\Connection;

use Kanagama\EloquentExpansion\Connection\Traits\QueryConnection;
use Illuminate\Database\PostgresConnection as BasePostgresConnection;

class PostgresConnection extends BasePostgresConnection
{
    use QueryConnection;
}
