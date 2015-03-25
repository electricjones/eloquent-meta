# Phoenix Eloquent Meta

[![Latest Version](https://img.shields.io/github/release/phoenix-labs/eloquent-meta.svg?style=flat-square)](https://github.com/phoenix-labs/eloquent-meta/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/phoenix-labs/eloquent-meta/master.svg?style=flat-square)](https://travis-ci.org/phoenix-labs/eloquent-meta)
[![Coverage Status](https://coveralls.io/repos/phoenix-labs/eloquent-meta/badge.svg?branch=master)](https://coveralls.io/r/phoenix-labs/eloquent-meta?branch=master)

This package was originally forked from the excellent **[ScubaClick Meta](https://github.com/ScubaClick/scubaclick-meta)**. It includes a trait and model to attach meta data to [Laravel's](http://laravel.com/) [Eloquent models](http://laravel.com/docs/eloquent). The project was forked in order to add a way to set a default return for getMeta() if nothing was set. It also allows the developer to create seperate database tables for different meta types (e.g. user_meta, profile_meta, etc).

##### Stable Version: 1.4.* works with Laravel 5.* or independently. Pulls Eloquent in automatically.
To use for Laravel 4, see version 1.2.*

## Installation

Install through Composer.

```js
"require": {
    "phoenix/eloquent-meta": "1.4.*"
}
```

That's everything if you are using EloquentMeta and Eloquent **without** using Laravel. You will have to setup Eloquent as detailed
in its [documentation](https://github.com/illuminate/database).

If you **are using Laravel**, then you'll want to include the ServiceProvider that will register commands and the like. Update `config/app.php` to include a reference to this package's service provider in the providers array.

```php
'providers' => [
    'Phoenix\EloquentMeta\ServiceProvider'
]
```

Finally, run the migration `php artisan vendor:publish` and `php artisan migrate` to create the database table.

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
[Phoenix Labs](http://phoenixlabstech.org) is a non-profit organization developing community-driven experiments in collaboration and content. "Community Driven" is more than just a slogan. It's a core value. Everything we do is for the community and by the community. Collaboration on any of the projects is welcome.

Please se [CONTRIBUTING.md] for more information and for testing.

### Thank you
Many thanks to [Boris Glumpler](https://github.com/shabushabu) and [ScubaClick](https://github.com/ScubaClick)!
