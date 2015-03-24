<?php
namespace Phoenix\EloquentMeta\Test\Stubs;

use Illuminate\Database\Eloquent\Model;
use Phoenix\EloquentMeta\MetaTrait;

class CustomModelParent extends Model
{
    use MetaTrait;

    protected $meta_model = 'Phoenix\EloquentMeta\Test\Stubs\CustomModelChild';

    public function modelMethod()
    {
        return 'this is a CustomModelParent method';
    }
}
