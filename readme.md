# EscapeWork\Msg

Library para fazer controle de mensagens.

### Exemplos 

```php
use EscapeWork\Msg\Msg;

Msg::setInfo('Info.');
Msg::setMessage('O registro foi inserido com sucesso!');
Msg::setWarning('Warning!!');
Msg::setError('Error!!!');
```

### Recebendo os erros 

```php
use EscapeWork\Msg\Msg;

Msg::getErrors();
```

### Recebendo todos os tipos de mensagens 

```php
use EscapeWork\Msg\Msg;

Msg::getAll();
```

### Laravel 4 

A EscapeWork\Msg funciona muito bem com o Laravel 4. E para facilitar ainda mais, você pode usar o `alias` do Laravel 4. 

Para isso, abra o arquivo `app/config/app.php`, e no array `aliases`, adicione a seguinte linha: 

```php
        'Msg' => 'EscapeWork\Msg\Msg'
```

### Instalação 

A instalação está disponível via [Composer](https://packagist.org/packages/escapework/msg). Autoload compátivel com a PSR-0.