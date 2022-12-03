<?php

namespace Kanagama\EloquentExpansion\Connection;

use Kanagama\EloquentExpansion\Connection\Traits\QueryConnection;
use Illuminate\Database\SQLiteConnection as BaseSQLiteConnection;

class SQLiteConnection extends BaseSQLiteConnection
{
    use QueryConnection;
}
