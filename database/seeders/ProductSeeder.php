<?php

namespace Database\Seeders;

use App\Models\Lote;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
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

            $lotes = Lote::factory(5)->make()->toArray();

            foreach ($lotes as $lote) {

                $lote = Lote::create($lote);

                $products = Product::factory(5)->make()->toArray();

                foreach ($products as $product){
                    $lote->products()->create($product);
                }
            }

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
