<?php

namespace Kanagama\EloquentExpansion\Connection;

use Kanagama\EloquentExpansion\Connection\Traits\QueryConnection;
use Illuminate\Database\MySqlConnection as BaseMySQLConnection;

class MySqlConnection extends BaseMySQLConnection
{
    use QueryConnection;
}
