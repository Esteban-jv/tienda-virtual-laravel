<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Nota, con php artisan tinker puedes usar "make" para ver un objeto sin id de tipo Product
        //pero también puedes crear 1 o más productos usando "create" y count->(10)->create(); para crear 10

         $users = User::factory(20)
             ->create()
             ->each(function ($user) {
                 $image = Image::factory()
                     ->user()
                     ->make();

                 $user->image()->save($image);
             });

         $orders = Order::factory(10)
             ->make() //Se crean las Order en memoria
             ->each(function ($order) use ($users) {
                 $order->customer_id = $users->random()->id;
                 $order->save(); //Se guarda cada Order en memoria

                 $payment = Payment::factory()->make();

//                 $payment->order_id = $order->id;     //Estas 2 lineas
//                 $payment->save();                    //Se reducen a la de abajo gracias a ->make() de arriba
                 $order->payment()->save($payment);
             });

         $carts = Cart::factory(20)->create();
         $products = Product::factory(50)
             ->create()
             ->each(function ($product) use ($orders, $carts) {
                 $order = $orders->random();
                 $order->products()->attach([
                     $product->id => ['quantity' => mt_rand(1,3)]
                 ]);

                 $cart = $carts->random();
                 $cart->products()->attach([
                     $product->id => ['quantity' => mt_rand(1,3)]
                 ]);

                 $images = Image::factory(mt_rand(2,4))->make();
                 $product->images()->saveMany($images);
             });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
