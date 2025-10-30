<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-3">
                <div class="product-thumbnails">
                    <div class="thumbnail-container mb-2" style="height: 80px; overflow: hidden; border: 1px solid #ddd; border-radius: 4px; padding: 5px; cursor: pointer;" 
                         onclick="document.getElementById('main-image').src = '{{ $product->cover_image_url }}?w=600'; document.getElementById('main-image').dataset.zoom = '{{ $product->cover_image_url }}?w=1200';">
                        <img src="{{ $product->cover_image_url }}?w=100" alt="{{ $product->name }}" 
                             class="img-fluid" style="width: 100%; height: 100%; object-fit: contain;"
                             onerror="this.onerror=null; this.src='{{ asset('images/NoData.png') }}'">
                    </div>
                    @if (isset($images) && !$images->isEmpty())
                        @foreach ($images as $image)
                            <div class="thumbnail-container mb-2" style="height: 80px; overflow: hidden; border: 1px solid #ddd; border-radius: 4px; padding: 5px; cursor: pointer;"
                                 onclick="document.getElementById('main-image').src = '{{ asset('storage/' . $image->src) }}?w=600'; document.getElementById('main-image').dataset.zoom = '{{ asset('storage/' . $image->src) }}?w=1200';">
                                <img src="{{ asset('storage/' . $image->src) }}?w=100" alt="{{ $product->name }}" 
                                     class="img-fluid" style="width: 100%; height: 100%; object-fit: contain;"
                                     onerror="this.onerror=null; this.src='{{ asset('images/NoData.png') }}'"
                                     loading="lazy">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="product-main-image" style="border: 1px solid #eee; border-radius: 4px; padding: 10px; text-align: center;">
                    <img id="main-image" class="img-fluid" 
                         src="{{ $product->cover_image_url }}?w=600" 
                         data-zoom="{{ $product->cover_image_url }}?w=1200" 
                         alt="{{ $product->name }}"
                         style="max-height: 500px; width: auto; max-width: 100%;"
                         onerror="this.onerror=null; this.src='{{ asset('images/NoData.png') }}'"
                         loading="eager">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="product-description">
            <h1>{{ $product->name }}
                <small>{{ config('cart.currency') }} {{ $product->price }}</small>
            </h1>
            <div class="description">{!! $product->description !!}</div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @include('layouts.errors-and-messages')
                    <form action="{{ route('cart.store') }}" class="form-inline" method="post">
                        {{ csrf_field() }}
                        @if (isset($productAttributes) && !$productAttributes->isEmpty())
                            <div class="form-group">
                                <label for="productAttribute">Choose Combination</label> <br />
                                <select name="productAttribute" id="productAttribute" class="form-control select2">
                                    @foreach ($productAttributes as $productAttribute)
                                        <option value="{{ $productAttribute->id }}">
                                            @foreach ($productAttribute->attributesValues as $value)
                                                {{ $value->attribute->name }} : {{ ucwords($value->value) }}
                                            @endforeach
                                            @if (!is_null($productAttribute->sale_price))
                                                ({{ config('cart.currency_symbol') }}
                                                {{ $productAttribute->sale_price }})
                                            @elseif(!is_null($productAttribute->price))
                                                ( {{ config('cart.currency_symbol') }} {{ $productAttribute->price }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                        @endif
                        <div class="form-group">
                            <input type="text" class="form-control" name="quantity" id="quantity"
                                placeholder="Quantity" value="{{ old('quantity') }}" />
                            <input type="hidden" name="product" value="{{ $product->id }}" />
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-cart-plus"></i> Add to cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var productPane = document.querySelector('.product-cover');
            var paneContainer = document.querySelector('.product-cover-wrap');

            new Drift(productPane, {
                paneContainer: paneContainer,
                inlinePane: false
            });
        });
    </script>
@endsection
