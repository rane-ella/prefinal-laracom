<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Transformations\ProductTransformable;

class HomeController
{
    use ProductTransformable;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * HomeController constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepo->listCategories('id', 'asc')->take(2)->values();

        $cat1 = $categories->get(0);
        if ($cat1) {
            $cat1->products = $cat1->products->map(function (Product $item) {
                return $this->transformProduct($item);
            });
        }

        $cat2 = $categories->get(1);
        if ($cat2) {
            $cat2->products = $cat2->products->map(function (Product $item) {
                return $this->transformProduct($item);
            });
        }

        return view('front.index', compact('cat1', 'cat2'));
    }
}
