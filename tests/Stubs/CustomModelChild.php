<?php
namespace Phoenix\EloquentMeta\Test\Stubs;

use Phoenix\EloquentMeta\Meta;
use Phoenix\EloquentMeta\MetaTrait;

class CustomModelChild extends Meta
{
    use MetaTrait;

    protected $table = "custom_model_meta";

    public function modelMethod()
    {
        return 'this is a CustomModelChild method';
    }
}
