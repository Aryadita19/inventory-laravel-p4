<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'sku' => strtoupper(fake()->unique()->bothify('???-###')),
            'name' => fake()->randomElement(['Kabel', 'Adaptor', 'Headset', 'Webcam', 'Printer', 'Stapler', 'Kursi', 'Lampu'])
                . ' ' . fake()->randomElement(['Pro', 'Mini', 'Basic', 'Plus', 'Ultra']),
            'price' => fake()->numberBetween(10, 2000) * 1000,
            'stock' => 0, // stok diisi lewat StockService di seeder agar ada histori
            'minimum_stock' => fake()->numberBetween(3, 10),
        ];
    }
}
