```sh
php artisan make:model Product -mfsc
php artisan make:model Course -mfsc
php artisan make:model OrderItem -mfsc
```

```php
OrderItem::getModel()->orderable()->getBaseQuery()->wheres
/*
    Returns:
    [
        [
            "type" => "Null",
            "column" => "order_items.",
            "boolean" => "and",
        ],
    ]
*/
```
