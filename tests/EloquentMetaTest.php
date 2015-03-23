<?php
namespace Phoenix\EloquentMeta\Test;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phoenix\EloquentMeta\Test\Stubs\Test;

class MetaTest extends \PHPUnit_Framework_TestCase
{
    public $db = false;
    public $testData;

    public function setup()
    {
        if (!$this->db) {
            $this->db = new Capsule;

            $this->db->addConnection([
                'driver'   => 'sqlite',
                'database' => __DIR__ . '/db/test.sqlite',
                'prefix'   => '',
            ]);

            // Make this Capsule instance available globally via static methods... (optional)
            $this->db->setAsGlobal();

            // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
            $this->db->bootEloquent();
        }

        Capsule::schema()->create('tests', function($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email');
        });

        Capsule::insert('insert into tests (name, email) values (?, ?)', ['Nicole', 'nicole@nicole.com']);
        Capsule::insert('insert into tests (name, email) values (?, ?)', ['Michael', 'michael@michael.com']);
        Capsule::insert('insert into tests (name, email) values (?, ?)', ['Jon', 'jon@jon.com']);

        $this->testData = new \stdClass();
        $this->testData->nicole = ['id' => 1, 'name' => 'Nicole', 'email' => 'nicole@nicole.com'];
        $this->testData->michael = ['id' => 2, 'name' => 'Michael', 'email' => 'michael@michael.com'];
        $this->testData->jon = ['id' => 3, 'name' => 'Jon', 'email' => 'jon@nicole.com'];
    }

    public function teardown()
    {
        Capsule::schema()->drop('tests');
    }

    public function testDatabaseSetup()
    {
        $result = Capsule::select('select * from tests where name = ?', ['Nicole']);
        $this->assertEquals([$this->testData->nicole], $result);
    }

    public function testModelSetup()
    {
        $result = Test::find(1);
        $this->assertEquals($this->testData->nicole, $result->toArray());
    }
}
