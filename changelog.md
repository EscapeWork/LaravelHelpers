### 0.7.*

- Renamed `EscapeWork\LaravelHelpers\Eloquent` to `EscapeWork\LaravelHelpers\BaseModel`;
- Renamed the `getValidationErrors` function to `messages`;
- Added `EscapeWork\LaravelHelpers\BaseCollection`;
- Added `EscapeWork\LaravelHelpers\BaseRepository`;
- Removed `BaseModel::$validationRules` and `BaseModel::$validationMessages`. Now, the proprieties are called `$rules` and `$messages`, and aren't static;
- Passed the `validate()` method to the `BaseRepository` field;
- Added the function `BaseModel::_setDateAttribute(field, value, format)` to set a date attribute. This transform the attribute in a Carbon object;
