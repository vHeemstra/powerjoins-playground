<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function create(Request $request)
    {
        $product = Product::firstOrFail();
        $course = Course::firstOrFail();

        $order_item = new OrderItem([
            'amount' => 1,
        ]);

        $order_item->orderable()->associate($product);
        // $order_item->orderable()->associate($course);

        $order_item->save();
    }

    public function testJoin()
    {
        dd(OrderItem::joinRelationship('orderable', morphable: Product::class)->toSQL());
        // dd(OrderItem::joinRelationship('orderable', morphable: Course::class)->toSQL());

        // dd(OrderItem::joinRelationship('orderable', [
        //     [Product::class] => function ($query) {
        //         $query->where('products.name', 'Product 1');
        //     },
        // ])->toSQL());

        // dd(OrderItem::leftJoinRelationship('orderable', morphable: Product::class)->toSQL());
    }
}
