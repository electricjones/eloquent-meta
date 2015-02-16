# Phoenix Eloquent Meta

This package was originally forked from the excellent **[ScubaClick Meta](https://github.com/ScubaClick/scubaclick-meta)**. It includes a trait and model to attach meta data to [Laravel's](http://laravel.com/) [Eloquent models](http://laravel.com/docs/eloquent). The project was forked in order to add a way to set a default return for getMeta() if nothing was set. It also allows the developer to create seperate database tables for different meta types (e.g. user_meta, profile_meta, etc).

##### Stable Version: 1.2.* works with Laravel 4.*
The `develop-L5` branch houses the in progress upgrade to Laravel 5

## Installation

Install through Composer.

```js
"require": {
    "phoenix/eloquent-meta": "1.2.*"
}
```

Next, update `app/config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Phoenix\EloquentMeta\ServiceProvider'
]
```

Finally, run the migration ```php artisan migrate --package="phoenix/eloquent-meta"``` to create the database table.

## Usage

Add the trait to all models that you want to attach meta data to:

```php
use Illuminate\Database\Eloquent\Model;
use Phoenix\EloquentMeta\MetaTrait;

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
use Phoenix\EloquentMeta\MetaTrait;

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

## Contributing
[Phoenix Labs](http://phoenixlabstech.org) is a non-profit organization developing community-driven experiments in collaboration and content. "Community Driven" is more than just a slogan. It's a core value. Everything we do is for the community and by the community. Collaboration on any of the projects is welcome.

To contribute to this project:
  * **Fork or clone** this repository. All work is done in the development branch which may have many feature branches. The master is always the latest, production ready release.
  * **Build** the library on your local machine.
    1. Simply install it into Laravel with above instructions
  * **Commit** your changes. All active files are in the /src/ directory.
  * **Test** as needed. Write tests and add them to one of the test suites in /tests/. Please write new tests as needed and make sure you didn't break another test.
  * **Issue a Pull Request** on this repository.
  
Be sure to be active. All discussion takes place in issue.
Phoenix Eloquent Meta is licenced under the MIT open source licence.

### Thank you
Many thanks to [Boris Glumpler](https://github.com/shabushabu) and [ScubaClick](https://github.com/ScubaClick)!
