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
6) Open Artisan Tinker by running: `php artisan tinker`
7) Type:
   ```php
   use App\Models\OrderItem;
   OrderItem::orderable()->getBaseQuery()->wheres;
   ```
8) Expected ouput:
   ```
   [
     [
       "type" => "Null",
       "column" => "order_items.",
       "boolean" => "and",
     ],
   ]
   ```
