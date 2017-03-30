<?php
namespace Phoenix\EloquentMeta\Test;

use Illuminate\Database\Capsule\Manager as Capsule;
use Phoenix\EloquentMeta\Test\Stubs\CustomModelParent;
use Phoenix\EloquentMeta\Test\Stubs\TestModel;

class MetaTest extends \PHPUnit_Framework_TestCase
{
    public $db = false;
    public $testData;

    public function setup()
    {
        if (!$this->db) {
            // Start with a clean slate
            file_put_contents(__DIR__ . "/db/test.sqlite", "");

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

            // Tests table
            Capsule::schema()->create('tests', function($table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('email');
            });

            // Meta Table
            Capsule::schema()->create('meta', function($table) {
                $table->increments('id');
                $table->integer('metable_id')->unsigned();
                $table->string('metable_type', 255);
                $table->string('key', 128);
                $table->text('value');

                $table->index('metable_id');
                $table->index('key');
            });

            Capsule::insert('insert into tests (name, email) values (?, ?)', ['Nicole', 'nicole@nicole.com']);
            Capsule::insert('insert into tests (name, email) values (?, ?)', ['Michael', 'michael@michael.com']);
            Capsule::insert('insert into tests (name, email) values (?, ?)', ['Jon', 'jon@jon.com']);
        }

        $this->testData = new \stdClass();
        $this->testData->nicole = ['id' => 1, 'name' => 'Nicole', 'email' => 'nicole@nicole.com'];
        $this->testData->michael = ['id' => 2, 'name' => 'Michael', 'email' => 'michael@michael.com'];
        $this->testData->jon = ['id' => 3, 'name' => 'Jon', 'email' => 'jon@nicole.com'];
    }

    public function teardown()
    {
        Capsule::schema()->drop('meta');
        Capsule::schema()->drop('tests');
    }

    public function test_database_setup()
    {
        $result = Capsule::select('select * from tests where name = ?', ['Nicole'])[0];
        $this->assertEquals($this->testData->nicole, get_object_vars($result));
    }

    public function test_model_setup()
    {
        $result = TestModel::find(1);
        $this->assertEquals($this->testData->nicole, $result->toArray());
    }

    public function test_add_and_get_meta()
    {
        $model = TestModel::find(1);
        $model->addMeta('testA', 'testA-value');
        $actual = $model->getMeta('testA');

        $this->assertEquals('testA-value', $actual, "failed to add and get single meta item");
    }

    public function test_get_meta_default_value()
    {
        $model = TestModel::find(1);
        $actual = $model->getMeta('testB', 'testB-default-value');

        $this->assertEquals('testB-default-value', $actual, "failed to get fallback for single meta item");
    }

    public function test_add_meta_as_array()
    {
        $model = TestModel::find(1);
        $model->addMeta('testC', ['testC-value', 'testC-second-value']);
        $actual = $model->getMeta('testC');

        $this->assertEquals(['testC-value', 'testC-second-value'], $actual, "failed to get array meta item");
    }

    public function test_update_meta()
    {
        $model = TestModel::find(1);
        $model->addMeta('testD', 'testD-original-value');
        $model->updateMeta('testD', 'testD-updated-value');
        $actual = $model->getMeta('testD');

        $this->assertEquals('testD-updated-value', $actual, "failed to update meta item");
    }

    public function test_delete_meta()
    {
        $model = TestModel::find(1);
        $model->addMeta('testE', 'testE-value');
        $model->deleteMeta('testE');
        $actual = $model->getMeta('testD');

        $this->assertNull($actual, "failed to delete meta item");
    }

    public function test_delete_all_meta()
    {
        $model = TestModel::find(1);
        $model->addMeta('testF-first', 'testF-first-value');
        $model->addMeta('testF-second', 'testF-second-value');
        $model->addMeta('testF-third', 'testF-third-value');

        $model->deleteAllMeta();

        $first = $model->getMeta('testF-first');
        $second = $model->getMeta('testF-second');
        $third = $model->getMeta('testF-third');

        $this->assertNull($first, "failed to delete first meta item");
        $this->assertNull($second, "failed to delete second meta item");
        $this->assertNull($third, "failed to delete third meta item");
    }

    public function test_append_meta()
    {
        $model = TestModel::find(1);
        $model->addMeta('testG', ['testG-value']);
        $model->appendMeta('testG', 'testG-appended-value');
        $actual = $model->getMeta('testG');

        $this->assertEquals(['testG-value', 'testG-appended-value'], $actual, "failed to get append meta item");
    }

    public function test_get_all_meta()
    {
        $model = TestModel::find(1);

        $model->addMeta('testH-first', 'testH-first-value');
        $model->addMeta('testH-second', 'testH-second-value');
        $model->addMeta('testH-third', 'testH-third-value');

        $actual = $model->getAllMeta();

        $this->assertEquals([
            'testH-first' => 'testH-first-value',
            'testH-second' => 'testH-second-value',
            'testH-third' => 'testH-third-value',
        ], $actual->toArray(), 'failed to get all meta');
    }

    public function test_model_methods()
    {
        $model = TestModel::find(1);
        $actual = $model->modelMethod();

        $this->assertEquals('this is a TestModel method', $actual, "failed to get append meta item");
    }

    public function test_custom_meta_model()
    {
        // This test is ridiculously complicated. There has to be an easier way!

        // The `CustomModelParent` model uses a custom model to handle it's meta
        // The `CustomModelChild` handles meta for `CustomModelParent`
        // The `CustomModelChild` uses `custom_model_meta` as its table

        // First, create the `custom_model_parents` table and insert a record
        Capsule::schema()->create('custom_model_parents', function($table) {
            $table->increments('id');
            $table->string('dummy', 255);
        });

        Capsule::insert('insert into custom_model_parents (dummy) values (?)', ['data']);

        // Second, create the `custom_model_meta` table
        Capsule::schema()->create('custom_model_meta', function($table) {
            $table->increments('id');
            $table->integer('metable_id')->unsigned();
            $table->string('metable_type', 255);
            $table->string('key', 128);
            $table->text('value');

            $table->index('metable_id');
            $table->index('key');
        });

        // Start up the parent
        $model = CustomModelParent::find(1);

        // Now test that the CustomModelParent is working
        $this->assertEquals('this is a CustomModelParent method', $model->modelMethod(), 'failed to use custom method for Parent');

        // TestModel that data is being saved to the correct table
        $model->addMeta('testTable', 'value');
        $results = Capsule::select('select * from custom_model_meta');

        $this->assertEquals([
            'id' => 1,
            'metable_id' => '1',
            'metable_type' => CustomModelParent::class,
            'key' => 'testTable',
            'value' => 'value'
        ], get_object_vars($results[0]), "failed to get save meta to correct table");

        // Last, clean up our tables
        Capsule::schema()->drop('custom_model_meta');
        Capsule::schema()->drop('custom_model_parents');
    }
}
