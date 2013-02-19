# LaravelHelpers

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

### Slug

Para criar um slug de um título ou algum outro atributo, utilize a função `formatSlug()`;

```php
$fields = [
    'title' => Input::get('title')
    'slug'  => Brand::formatSlug( Input::get('title') )
];

Brand::create( $fields );
```