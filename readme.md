# LaravelHelpers [![Build Status](https://secure.travis-ci.org/EscapeWork/LaravelHelpers.png)](http://travis-ci.org/EscapeWork/LaravelHelpers) [![Latest Stable Version](https://poser.pugx.org/escapework/laravelhelpers/v/stable.png)](https://packagist.org/packages/escapework/laravelhelpers) [![Total Downloads](https://poser.pugx.org/escapework/laravelhelpers/downloads.png)](https://packagist.org/packages/escapework/laravelhelpers)

A set of tools and helpers to help the [Laravel 4](http://laravel.com) development.

### Instalation

Install via [Composer](https://packagist.org/packages/escapework/laravelhelpers).

```javascript
{
    "require": {
        "escapework/laravelhelpers": "0.5.*"
    }
}
```

### Configuration

Change the `Eloquent` alias to `EscapeWork\LaravelHelpers\Eloquent`;

***

### Slugs

If you need to make an slug for your model, just set the `$sluggable` as true.

```php
class Product extends Eloquent
{

    protected $sluggable = true;
}
```

When executing the `save` and `update` method, the slug is going to be automatically generated by the helper. 

The default slug is made by the attribute `title`. But if you have a diferent attribute, just declare the `$sluggableAttr` with the field name.

```php
protected $sluggableAttr = 'name';
```

```php
    public function store()
    {
        $this->product->title = 'Hello World';
        $this->product->save();

        echo $this->product->slug; // prints hello-world
    }
}
```

We use the [Cocur\Slugify](https://github.com/cocur/slugify) to create the slugs.

***

### Validations

Just set the `$validationRules` and `$validationMessages` in your model, then call `$model->validate()`.

```php
class User extends Eloquent
{

    public static $validationRules = array(
        'title' => array('required')
    );

    public static $validationMessages = array(
        'title.required' => 'O título é obrigatório'
    );
}
```

And you can validate your models just calling the `validate()` method.

```php
class UserTest extends TestCase
{

    public function testValidate()
    {
        $user = new User();
        $user->fill(['title' => 'Testing']);

        $this->assertTrue($user->validate());
    }
}
```

If your validation fails, error messages will be set in the static variable `$messages` as an array.

```php
    dd(User::$messages);
```

Case you wish the Laravel `MessageBag` object, you can access in the attribute `$messageBag`.

```php
$user->messageBag()
```

***

### HTML Options

```php
<select name="user_id">
    {{ $user->HTMLOptions() }}
</select>

<select>
    {{ $user->HTMLOptions(2, 'name', User::getAdministrators()) }}
</select>
```