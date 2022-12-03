<?php

namespace Kanagama\EloquentExpansion\Connection;

use Kanagama\EloquentExpansion\Connection\Traits\QueryConnection;
use Illuminate\Database\SqlServerConnection as BaseSqlServerConnection;

class SqlServerConnection extends BaseSqlServerConnection
{
    use QueryConnection;
}
