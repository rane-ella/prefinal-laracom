<?php

namespace App\Shop\Products;

use App\Shop\Brands\Brand;
use App\Shop\Categories\Category;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductImages\ProductImage;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements Buyable
{
    use SearchableTrait;

    public const MASS_UNIT = [
        'OUNCES' => 'oz',
        'GRAMS' => 'gms',
        'POUNDS' => 'lbs'
    ];

    public const DISTANCE_UNIT = [
        'CENTIMETER' => 'cm',
        'METER' => 'mtr',
        'INCH' => 'in',
        'MILLIMETER' => 'mm',
        'FOOT' => 'ft',
        'YARD' => 'yd'
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'products.name' => 10,
            'products.description' => 5
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'name',
        'description',
        'cover',
        'quantity',
        'price',
        'brand_id',
        'status',
        'weight',
        'mass_unit',
        'status',
        'sale_price',
        'length',
        'width',
        'height',
        'distance_unit',
        'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @param null $options
     * @return int|string
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @param null $options
     * @return string
     */
    public function getBuyableDescription($options = null)
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @param null $options
     * @return float
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @param string $term
     * @return Collection
     */
    public function searchProduct(string $term) : Collection
    {
        return self::search($term)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the URL for the product's cover image.
     *
     * @return string
     */
    public function getCoverImageUrlAttribute()
    {
        // If no cover image is set, return the default image
        if (empty($this->cover)) {
            return $this->getDefaultImageUrl();
        }

        // If it's already a full URL, return it
        if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
            return $this->cover;
        }

        // Clean up the path - replace backslashes with forward slashes
        $path = str_replace('\\', '/', $this->cover);
        $path = ltrim($path, '/');
        $path = str_replace(['storage/', 'products/'], '', $path);
        
        // Build the URL to the image
        $imageUrl = asset('storage/products/' . $path);
        
        // Log the URL for debugging
        \Log::info('Generated image URL:', [
            'product_id' => $this->id,
            'cover' => $this->cover,
            'path' => $path,
            'url' => $imageUrl
        ]);
        
        return $imageUrl;
    }
    
    /**
     * Get the URL for the default product image.
     *
     * @return string
     */
    protected function getDefaultImageUrl()
    {
        $defaultImage = 'images/no-image-available.jpg';
        $defaultImagePath = public_path($defaultImage);
        
        // Create the default image if it doesn't exist
        if (!file_exists($defaultImagePath)) {
            if (!is_dir(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }
            
            $img = imagecreatetruecolor(400, 300);
            $bgColor = imagecolorallocate($img, 240, 240, 240);
            $textColor = imagecolorallocate($img, 150, 150, 150);
            
            imagefill($img, 0, 0, $bgColor);
            imagestring($img, 5, 80, 140, 'No Image Available', $textColor);
            
            imagejpeg($img, $defaultImagePath, 80);
            imagedestroy($img);
        }
        
        return asset($defaultImage);
    }
    
    /**
     * Get the relative path between two paths
     *
     * @param string $from
     * @param string $to
     * @return string
     */
    protected function getRelativePath($from, $to)
    {
        // Remove drive letter if present
        $from = is_dir($from) ? rtrim($from, '\\/') . '/' : $from;
        $to = is_dir($to) ? rtrim($to, '\\/') . '/' : $to;
        
        $from = str_replace('\\', '/', $from);
        $to = str_replace('\\', '/', $to);
        
        $from = explode('/', $from);
        $to = explode('/', $to);
        
        $relativePath = $to;
        
        foreach ($from as $depth => $dir) {
            if ($dir === $to[$depth]) {
                array_shift($relativePath);
            } else {
                $remaining = count($from) - $depth;
                if ($remaining > 1) {
                    $relativePath = array_pad($relativePath, -1 * (count($relativePath) + $remaining - 1), '..');
                    break;
                } else {
                    $relativePath[0] = './' . $relativePath[0];
                }
            }
        }
        
        return implode('/', $relativePath);
    }
}
