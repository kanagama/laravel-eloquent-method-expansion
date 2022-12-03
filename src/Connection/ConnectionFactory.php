<?php

namespace Kanagama\EloquentExpansion\Connection;

use Kanagama\EloquentExpansion\Connection\MySqlConnection;
use Kanagama\EloquentExpansion\Connection\PostgresConnection;
use Kanagama\EloquentExpansion\Connection\SQLiteConnection;
use Kanagama\EloquentExpansion\Connection\SqlServerConnection;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory as BaseConnectionFactory;
use InvalidArgumentException;

class ConnectionFactory extends BaseConnectionFactory
{
    /**
     * Create a new connection instance.
     *
     * @param  string  $driver
     * @param  \PDO|\Closure  $connection
     * @param  string  $database
     * @param  string  $prefix
     * @param  array  $config
     * @return \Illuminate\Database\Connection
     *
     * @throws \InvalidArgumentException
     */
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($resolver = Connection::getResolver($driver)) {
            return $resolver($connection, $database, $prefix, $config);
        }

        return match ($driver) {
            'mysql' => new MySqlConnection($connection, $database, $prefix, $config),
            'pgsql' => new PostgresConnection($connection, $database, $prefix, $config),
            'sqlite' => new SQLiteConnection($connection, $database, $prefix, $config),
            'sqlsrv' => new SqlServerConnection($connection, $database, $prefix, $config),
            default => throw new InvalidArgumentException("Unsupported driver [{$driver}]."),
        };
    }
}
