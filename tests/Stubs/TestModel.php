<?php
namespace Phoenix\EloquentMeta\Test\Stubs;

use Illuminate\Database\Eloquent\Model;
use Phoenix\EloquentMeta\MetaTrait;

class Test extends Model
{
    use MetaTrait;

    public function modelMethod()
    {
        return 'this is a TestModel method';
    }
}
