<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Size::insert([
            ["size_name" => "S"],
            ["size_name" => "M"],
            ["size_name" => "L"],
        ]);

        $categories = json_decode(Storage::get("seed/category.json"), true);
        foreach ($categories as $category) {
            $id = Category::create(["category_name" => $category["category"]])->category_id;
            foreach ($category["child"] as $child) {
                Category::create(["category_name" => $child, "category_parent" => $id]);
            }
        }

        $data = json_decode(Storage::get("seed/product.json"), true);
        foreach ($data as $item) {
            $category = $item['category'];
            foreach ($item["data"] as $product) {
                $model = Product::create([
                    "product_name" => $product['name'],
                    "product_price" => $product['price'] > 1000000000 ? $product['price'] / 100000 : $product['price'],
                    "product_cost" => 100000,
                    "product_desc" => $product['descript'],
                    "product_avt" => $product['image'][0],
                    "category_id" => $category
                ]);
                foreach ($product['image'] as $i) {
                    $image=$model->images()->create(["image_link" => $i]);
                    $model->update(['product_avt'=>$image->{Image::COL_ID}]);
                }
                $model->sizes()->attach([
                    1 => ["quantity" => 10],
                    2 => ["quantity" => 10],
                    3 => ["quantity" => 10],
                ]);
            }
        }
    }
}
