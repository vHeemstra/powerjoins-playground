```sh
php artisan make:model Product -mfsc
php artisan make:model Course -mfsc
php artisan make:model OrderItem -mfsc
```

```php
use App\Models\OrderItem;
use App\Models\Product;

OrderItem::getModel()->orderable()->getBaseQuery()->wheres;
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

$p = OrderItem::joinRelationship('orderable', morphable: Product::class);
/* This throws a deprecation warning if the correct check in
   `getPowerJoinExistenceCompareKey` is not used.
*/

$p->getQuery()->toSQL();
/* Returns:
  select `order_items`.*
  from `order_items`
  inner join `products`
    on `order_items`.`orderable_id` = `products`.`id`
    and `order_items`.`orderable_type` = ?
    and `order_items`.`deleted_at` is null    <-- THIS SHOULD BE: `products`.`deleted_at`
    and `order_items`.`` is null              <-- THIS SHOULD NOT BE HERE (= the default WHERE clause)
*/

$p->get();
/* This throws an error about the empy column name from the SQL above. */
```
