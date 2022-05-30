<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "manufacturing_date" => date('Y-m-d H:i:s'),
            "quantity" => 10,
        ];
    }
}
