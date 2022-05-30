<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $clientes = Client::factory(3)->make()->toArray();

            foreach ($clientes as $cliente) {
                $cliente = Client::create($cliente);
                $items = Product::all();
                $items_count = Product::all()->count();
                if ($items_count == 0){
                    dd('run : php artisan db:seed --class=ProductSeeder');
                }
                $ids = '';
                foreach ($items as $item) {
                    $ids .= $item['id'] . ',';
                }
                $explode = explode(',', $ids);
                $items_id = '';
                for ($i = 0; $i < 4; $i++) {
                    $items_id .= $explode[rand(0, count($explode))] . ',';
                }

                $order = [
                    'user_id' => (User::all()->first())->id,
                    'items_id' => $items_id,
                    'total_amount' => 50000
                ];

                $cliente->orders()->create($order);


            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


    }
}
