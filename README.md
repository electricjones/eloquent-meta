# Phoenix Eloquent Meta

[![Latest Version](https://img.shields.io/github/release/chrismichaels84/eloquent-meta.svg?style=flat-square)](https://github.com/phoenix-labs/eloquent-meta/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/chrismichaels84/eloquent-meta/master.svg?style=flat-square)](https://travis-ci.org/phoenix-labs/eloquent-meta)
[![Total Downloads](https://img.shields.io/packagist/dt/phoenix/eloquent-meta.svg?style=flat-square)](https://packagist.org/packages/phoenix/eloquent-meta)

Attach meta data to [Laravel's](http://laravel.com/) [Eloquent models](http://laravel.com/docs/eloquent).
  * Optionally create a separate table for each Model
  * Use with or without Laravel
  * Includes Laravel migrations or schema instructions
  * Get meta or fallback

##### Which Version?
- Lavavel 5.7 - use `1.9.*`
- Laravel 5.6 - use `1.8.*`
- Laravel 5.5 - use `1.7.*`
- Laravel 5.4 - Use `1.6.*`
- Laravel 5.3 - Use `1.5.*`
- Below 5.3 - Not technically supported, but should work with `.1.3`
- Laravel 4 - Also not supported, but should work with `1.2`

##### Stable Version: 1.4.* works with Laravel 5.* or independently. Pulls Eloquent in automatically.
To use for Laravel 4, see version 1.2.*

## Installation
Install through Composer.

```js
"require": {
    "phoenix/eloquent-meta": "1.6.*"
}
```

Please note only php `5.6` and `7`+ are supported.

If you are using EloquentMeta and Eloquent **without** using Laravel, 
you will also have to setup Eloquent as detailed in its [documentation](https://github.com/illuminate/database).

If you **are using Laravel**, then you'll want to include the ServiceProvider that will register commands and the like. Update `config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Phoenix\EloquentMeta\ServiceProvider'
]
```

### Table Structure
If you are using Laravel, run the migration `php artisan vendor:publish` and `php artisan migrate` to create the database table.

If you **are not using Laravel** then you must create the table manually.

```sql
CREATE TABLE meta
(
    id INTEGER PRIMARY KEY NOT NULL,
    metable_id INTEGER NOT NULL,
    metable_type TEXT NOT NULL,
    key TEXT NOT NULL,
    value TEXT NOT NULL
);
CREATE UNIQUE INDEX meta_key_index ON meta (key);
CREATE UNIQUE INDEX meta_metable_id_index ON meta (metable_id);

```

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

If you are using EloquentMeta independent of Laravel, then you will have to create the database table manually.

If you are using Laravel, then include the service provider in your config/app.php

```php
'providers' => [
    'Phoenix\EloquentMeta\ServiceProvider'
]
```

Then run ```php artisan generate:metatable table_name``` to create the migration and run ```php artisan migrate``` to build the table.

## Contributing
Please se [CONTRIBUTING.md] for more information and for testing.

### Thank you and Credits
Contributors
  - Michael Wilson - @[chrismichaels84](http://github.com/chrismichaels84) - Maintainer
  - Paweł Ciesielski - @[dzafel](http://github.com/dzafel)
  - Lukas Knuth - @[LukasKnuth](http://github.com/LukasKnuth)
  - @[stephandesouza](http://github.com/stephandesouza)
 
Many thanks to [Boris Glumpler](https://github.com/shabushabu) and [ScubaClick](https://github.com/ScubaClick) for the original package!

