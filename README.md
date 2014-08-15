<<<<<<< HEAD
Phoenix Meta
=======
Phoenix Eloquent Meta
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca
===============
This package was originally forked from the excellent [ScubaClick Meta](https://github.com/ScubaClick/scubaclick-meta). 

Trait and model to attach meta data to Eloquent models.
Developed for [Phoenix](http://Phoenix.com) and is considered stable now!

Stable Version
--------------
v1.0.1

General Installation
--------------------

Install by adding the following to the require block in composer.json:
```
<<<<<<< HEAD
"Phoenix/meta": "1.*"
=======
"phoenix/eloquent-meta": "1.*"
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca
```

Then run `composer update`.

Run Migrations
--------------

```
<<<<<<< HEAD
php artisan migrate --package="Phoenix/meta"
=======
php artisan migrate --package="phoenix/eloquentmeta"
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca

```

Usage
-----

Add the trait to all models that you want to attach meta data to:

```php
use Illuminate\Database\Eloquent\Model;

class SomeModel extends Model
{
<<<<<<< HEAD
    use \Phoenix\Meta\MetaTrait;
=======
    use \Phoenix\EloquentMeta\MetaTrait;
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca

    // model methods
}
```

Then use like this:

```php
$model = SomeModel::find(1);
$model->getAllMeta();
$model->getMeta('some_key');
$model->updateMeta('some_key', 'New Value');
$model->deleteMeta('some_key');
$model->deleteAllMeta();
$model->addMeta('new_key', ['First Value']);
$model->appendMeta('new_key', 'Second Value');
```

Unique Meta Models and Tables
-----
You can also define a specific meta model for a meta type. For instance, your User model can use UserMeta model with custom methods and all. In the parent model,

```php
class User extends Eloquent {
    protected $meta_model = 'Full\Namespace\UserMeta';
}
```
Then in UserMeta simply extends \Phoenix\Meta\Meta.

Finally, if you want UserMeta stored in a dedicated users_meta table (or any other table name), declare it in the meta model.
```php
<<<<<<< HEAD
class UserMeta extends \Phoenix\Meta\Meta {
=======
class UserMeta extends \Phoenix\EloquentMeta\Meta {
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca
    protected $table = "users_meta";
}
```

You can create the users_meta table manually, or include MetaServiceProvider in your app/config/app.php
```php
'providers' => array(
    ...
<<<<<<< HEAD
    'Phoenix\Meta\MetaServiceProvider'
=======
    'Phoenix\EloquentMeta\MetaServiceProvider'
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca
```
Then, you can run ```php artisan generate:metatable table_name``` to create the migration and run ```php artisan migrate``` to build the users_meta table.

License
-------

<<<<<<< HEAD
Phoenix Meta is licenced under the MIT license.
=======
Phoenix Eloquent Meta is licenced under the MIT license.
>>>>>>> feae8ae92396c41965960b4d8db82de793be1eca
