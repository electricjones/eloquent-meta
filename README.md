# Phoenix Eloquent Meta

This package was originally forked from the excellent **[ScubaClick Meta](https://github.com/ScubaClick/scubaclick-meta)**. It includes a trait and model to attach meta data to [Laravel's](http://laravel.com/) [Eloquent models](http://laravel.com/docs/eloquent). The project was forked in order to add a way to set a default return for getMeta() if nothing was set. It also allows the developer to create seperate database tables for different meta types (e.g. user_meta, profile_meta, etc).

Though not required, Eloquent Meta also works with [Phoenix Larvel Repositories](http://github.com/phoenix-labs/laravel-repositories). 

##### Stable Version: 1.2.0

## Installation

Install through Composer.

```js
"require": {
    "phoenix/eloquent-meta": "~1.0"
}
```

Next, update `app/config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Phoenix\EloquentMeta\ServiceProvider'
]
```

Finally, run the migration ```php artisan migrate --package="phoenix/eloquentmeta"``` to create the database table.

## Usage

Add the trait to all models that you want to attach meta data to:

```php
use Illuminate\Database\Eloquent\Model;
use Phoneix\EloquentMeta\MetaTrait;

class SomeModel extends Model
{
    use MetaTrait;

    // model methods
}
```

Then use like this:

```php
$model = SomeModel::find(1);
$model->getAllMeta();
$model->getMeta('some_key', 'optional default value'); // default value only returned if no meta found.
$model->updateMeta('some_key', 'New Value');
$model->deleteMeta('some_key');
$model->deleteAllMeta();
$model->addMeta('new_key', ['First Value']);
$model->appendMeta('new_key', 'Second Value');
```

### Unique Meta Models and Tables

You can also define a specific meta model for a meta type. For instance, your User model can use UserMeta model with custom methods and all. Using the example above:

```php
use Illuminate\Database\Eloquent\Model;
use Phoneix\EloquentMeta\MetaTrait;

class SomeModel extends Model
{
    use MetaTrait;
    
    protected $meta_model = 'Fully\Namespaced\SomeModelMeta';

    // model methods
}
```
Then in SomeModelMeta simply extends Phoenix\EloquentMeta\Meta. You may now add custom methods to the meta model. You may also dictate which table the metadata is saved to by adding

```php
protected $table = "whatever_table";
```

You can create the users_meta table manually, or include MetaServiceProvider in your app/config/app.php
```php
'providers' => array(
    ...
    'Phoenix\EloquentMeta\MetaServiceProvider'
```
Then run ```php artisan generate:metatable table_name``` to create the migration and run ```php artisan migrate``` to build the users_meta table.

### License

Phoenix Eloquent Meta is licenced under the MIT license.

### Thank you

Many thanks to [Boris Glumpler](https://github.com/shabushabu) and [ScubaClick](https://github.com/ScubaClick)!
