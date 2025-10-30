<?php

namespace Database\Seeders;

use App\Shop\Products\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImagesSeeder extends Seeder
{
    private $images = [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600',
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600',
        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600',
        'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600',
        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=600',
    ];

    public function run()
    {
        // Ensure the directory exists
        Storage::disk('public')->makeDirectory('products');

        $products = Product::all();
        $imageIndex = 0;

        foreach ($products as $product) {
            if ($imageIndex >= count($this->images)) {
                $imageIndex = 0;
            }

            $imageUrl = $this->images[$imageIndex];
            $imageContent = file_get_contents($imageUrl);
            $imageName = 'product-' . $product->id . '-' . time() . '.jpg';
            
            // Store the image in the public disk
            Storage::disk('public')->put('products/' . $imageName, $imageContent);
            
            // Update the product with the correct path (without 'products/' prefix as it's already in the disk path)
            $product->update([
                'cover' => $imageName
            ]);

            $imageIndex++;
        }
    }
}
