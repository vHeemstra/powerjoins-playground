## Install

1) Clone repo
2) Create MySQL database
3) Copy `.env.example` to `.env` and edit its contents for the database
4) Start your MySQL server
5) Open a terminal in the root folder and run:
   ```sh
   composer install
   php artisan migrate
   ```

## Reproduce (related) bugs
#### 1. Strange `WHERE` clause by default
1) Open Artisan Tinker and run:
   ```php
   use App\Models\OrderItem;
   OrderItem::getModel()->orderable()->getBaseQuery()->wheres;
   ```
2) Expected ouput:
   ```
   [
     [
       "type" => "Null",
       "column" => "order_items.",
       "boolean" => "and",
     ],
   ]
   ```

#### 2. Interferance of this `WHERE` clause
1) Open Artisan Tinker and run:
   ```php
   use App\Models\OrderItem;
   use App\Models\Product;
   $p = OrderItem::joinRelationship('orderable', morphable: Product::class);
   ```
2) Expected output:
   ```
    DEPRECATED  str_contains(): Passing null to parameter #1 ($haystack) of type string is deprecated
    in vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php on line 569.
   ```
3) When getting the SQL from this Eloquent Builder, the strange `WHERE` clause has gone:
   ```php
   $p->getQuery()->toSQL()
   /* Returns SQL string:
     select `order_items`.*
     from `order_items`
     inner join `products`
       on `order_items`.`orderable_id` = `products`.`id`
       and `order_items`.`orderable_type` = ?
       and `order_items`.`deleted_at` is null
   */
   ```

_So, while compiling/preparing the query, the empty-column `WHERE` clause interferes and throws an error (see 2), but it gets removed/filtered out/ignored somehow while preparing the SQL statement._

#### 3. Wrong column name method used for `MorphTo` relations
Besides the strange `WHERE` clause, the preparation of the Eloquent Builder also uses a wrong check inside `Kirschbaum\PowerJoins\Mixins\RelationshipsExtraMethods::getPowerJoinExistenceCompareKey()` for the identifying columns for the `MorphTo` relation.

Since `MorphTo` extends the `BelongsTo` relation, the column name is retreived by calling `getQualifiedOwnerKeyName()` on the relationship. This results in an deprecation warning (same as above) and a empty column name:
1) Open Artisan Tinker and run:
   ```php
   use App\Models\OrderItem;
   OrderItem::getModel()->orderable()->getQualifiedOwnerKeyName();
   // Returns: "order_items."
   ```

