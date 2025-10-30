@if (!empty($products) && !collect($products)->isEmpty())
    <ul class="row text-center list-unstyled">
        @foreach ($products as $product)
            <li class="col-md-3 col-sm-6 col-xs-12 product-list">
                <div class="single-product">
                    <div class="product">
                        <div class="product-overlay">
                            <div class="vcenter">
                                <div class="centrize">
                                    <ul class="list-unstyled list-group">
                                        <li>
                                            <form action="{{ route('cart.store') }}" class="form-inline" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="quantity" value="1" />
                                                <input type="hidden" name="product" value="{{ $product->id }}">
                                                <button id="add-to-cart-btn" type="submit" class="btn btn-warning"
                                                    data-toggle="modal" data-target="#cart-modal"> <i
                                                        class="fa fa-cart-plus"></i> Add to cart</button>
                                            </form>
                                        </li>
                                        <li> <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#myModal_{{ $product->id }}"> <i class="fa fa-eye"></i>
                                                Quick View</button>
                                        <li> <a class="btn btn-default product-btn"
                                                href="{{ route('front.get.product', $product->slug) }}"> <i
                                                    class="fa fa-link"></i> Go to product</a> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-image-container" style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 1px solid #eee; border-radius: 4px; padding: 10px;">
                            @php
                                $imageUrl = $product->cover_image_url;
                                $imageExists = false;
                                
                                // Check if the image exists in storage
                                if (!empty($product->cover)) {
                                    $path = ltrim($product->cover, '/');
                                    $path = str_replace(['storage/', 'products/'], '', $path);
                                    $storagePath = storage_path('app/public/products/' . $path);
                                    $imageExists = file_exists($storagePath);
                                    
                                    \Log::info('Product image check:', [
                                        'product_id' => $product->id,
                                        'cover' => $product->cover,
                                        'path' => $storagePath,
                                        'exists' => $imageExists ? 'yes' : 'no',
                                        'url' => $imageUrl
                                    ]);
                                }
                            @endphp
                            
                            @if($imageExists || filter_var($product->cover, FILTER_VALIDATE_URL))
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                    class="img-fluid" 
                                    style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                    onerror="this.onerror=null; this.src='{{ asset('images/no-image-available.jpg') }}'"
                                    loading="lazy">
                            @else
                                <div style="text-align: center; width: 100%;">
                                    <i class="fa fa-image fa-4x" style="color: #ddd; margin-bottom: 10px;"></i>
                                    <p style="color: #999;">No Image Available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="product-text">
                        <h4>{{ $product->name }}</h4>
                        <p>
                            {{ config('cart.currency') }}
                            @if (!is_null($product->attributes->where('default', 1)->first()))
                                @if (!is_null($product->attributes->where('default', 1)->first()->sale_price))
                                    {{ number_format($product->attributes->where('default', 1)->first()->sale_price, 2) }}
                                    <p class="text text-danger">Sale!</p>
                                @else
                                    {{ number_format($product->attributes->where('default', 1)->first()->price, 2) }}
                                @endif
                            @else
                                {{ number_format($product->price, 2) }}
                            @endif
                        </p>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal_{{ $product->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                @include('layouts.front.product')
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        @if ($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">{{ $products->links() }}</div>
                </div>
            </div>
        @endif
    </ul>
@else
    <p class="alert alert-warning">No products yet.</p>
@endif
