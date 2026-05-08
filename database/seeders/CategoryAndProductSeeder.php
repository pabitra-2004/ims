<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products =  Http::get("https://api.escuelajs.co/api/v1/products")->object();

        foreach ($products as $__product) {

            $__category = $__product->category;

            $category = Category::whereSlug($__category->slug)->firstOrNew();
            if (!$category->exists) {

                $category->name = $__category->name;
                $category->slug = $__category->slug;
                $category->save();
            }

            $product = Product::whereSlug($__product->slug)->firstOrNew();
            if (!$product->exists) {
                $product->category_id = $category->id;
                $product->code = fake()->unique()->regexify('[A-Z]{3}[0-4]{5}');
                $product->name = $__product->title;
                $product->slug = $__product->slug;
                $product->price = $__product->price;
                $product->description = $__product->description;

                $__images = [];
                foreach ($__product->images as $image) {
                    $imageContents = file_get_contents($image);
                    $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
                    $imageName = "images/products/" . str()->random(40) . "." . $imageExtension;

                    if (Storage::disk('public')->put($imageName, $imageContents)) {
                        // Handle the error, e.g., log it or throw an exception
                        $__images[] = $imageName;
                    }
                }
                $product->images = $__images;
                // dd($__images);

                $product->save();
            }
        }
    }
}
