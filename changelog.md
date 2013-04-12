### 0.2.3

- Removido pré condição de ser um array da função `formatArrayKeysByField`;

### 0.2.2

- Adicionada a função `formatArrayKeysByField`;

### 0.2.1 

- Adicionada attributo `$sluggable`, onde é montando o slug automáticamente nas funções `save` e `delete`;

### 0.2

- Função `setFields` utiliza o array `Eloquent::$fillable` ao invés do array `$fields`, que não era nativo do Eloquent;

### 0.1

- Função `EscapeWork\LaravelHelpers\Eloquent\validate()`;
- Função `EscapeWork\LaravelHelpers\Eloquent\getDataFromArray()`;
- Atributos `EscapeWork\LaravelHelpers\Eloquent\$validationRules`, `EscapeWork\LaravelHelpers\Eloquent\$validationMessages`, `EscapeWork\LaravelHelpers\Eloquent\$messages`;
- Função `EscapeWork\LaravelHelpers\Eloquent\HTMLOptions()`;