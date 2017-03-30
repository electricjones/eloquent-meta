<?php
namespace Phoenix\EloquentMeta\Test\Stubs;

use Illuminate\Database\Eloquent\Model;
use Phoenix\EloquentMeta\MetaTrait;

class TestModel extends Model
{
    use MetaTrait;

    public $table = 'tests';

    public function modelMethod()
    {
        return 'this is a TestModel method';
    }
}
