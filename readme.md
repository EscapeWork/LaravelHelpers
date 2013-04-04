# LaravelHelpers (Beta) [![Build Status](https://secure.travis-ci.org/EscapeWork/LaravelHelpers.png)](http://travis-ci.org/EscapeWork/LaravelHelpers)

### Instalação

A instalação está disponível via [Composer](https://packagist.org/packages/escapework/laravelhelpers). Autoload compátivel com a PSR-0.

```
{
    "require": {
        "escapework/laravelhelpers": "0.1.*"
    }
}
```

### Configuração

- Altere o Alias da Eloquent para `EscapeWork\LaravelHelpers\Eloquent`;

### Validação

Apenas defina as regras de validação do seu model: 

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

E depois, você já pode validar o seu Model.

```php
class UserTest extends TestCase
{

    public function testValidate()
    {
        $fields = [
            'title' => 'Testing'
        ];

        $this->assertTrue( User::validate( $fields ) );
    }
}
```

### HTML Options

```php
<select>
    {{ Brand::HTMLOptions() }}
</select>

<select>
    {{ User::HTMLOptions(2, 'name', User::getAdministrators()) }}
</select>
```

***

### Eventos

Comming soon.

***

### Populando o objeto por um array

Comming soon.

***