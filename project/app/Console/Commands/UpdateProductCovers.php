<?php

namespace App\Console\Commands;

use App\Shop\Products\Product;
use Illuminate\Console\Command;

class UpdateProductCovers extends Command
{
    protected $signature = 'products:update-covers';
    protected $description = 'Update product cover images to use local paths';

    public function handle()
    {
        $products = Product::all();
        
        foreach ($products as $index => $product) {
            if (strpos($product->cover, 'NoData.png') !== false) {
                $productNumber = ($index % 12) + 1; // We have 12 product images
                $newCover = "products/product-{$productNumber}-1761466281.jpg";
                
                $product->cover = $newCover;
                $product->save();
                
                $this->info("Updated product {$product->id} cover to: {$newCover}");
            }
        }
        
        $this->info('All product covers have been updated!');
    }
}
