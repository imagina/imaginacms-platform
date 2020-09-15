<?php
namespace Tests;

use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\Schema\{SQLiteBuilder, Blueprint};
use Illuminate\Support\Fluent;
use Orchestra\Testbench\TestCase;

abstract class ImaginaBaseTestCase extends TestCase
{

    /**
     *
     */
    public function setUp()
    {
        $this->hotfixSqlite();
        parent::setUp();
    }

    /**
     *
     */
    public function hotfixSqlite()
    {
        \Illuminate\Database\Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new class($connection, $database, $prefix, $config) extends SQLiteConnection {
                public function getSchemaBuilder()
                {
                    if ($this->schemaGrammar === null) {
                        $this->useDefaultSchemaGrammar();
                    }
                    return new class($this) extends SQLiteBuilder {
                        protected function createBlueprint($table, \Closure $callback = null)
                        {
                            return new class($table, $callback) extends Blueprint {
                                public function dropForeign($index)
                                {
                                    return new Fluent();
                                }
                            };
                        }
                    };
                }
            };
        });
    }

}