<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    {{-- @dd(session('cart')) --}}
    <div class="offcanvas-header">
        <h5 class="offcanvas-title font-bold text-xl" id="offcanvasRightLabel">Booking Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <button class="absolute top-1 right-1 rounded-full bg-gray-200 hover:bg-gray-300 p-1 text-gray-800"
        data-dismiss="offcanvas" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
        <i class="fas fa-times"></i>
    </button>
    <div class="offcanvas-body relative overflow-hidden">
        @if (session()->get('cart'))
            @foreach (session('cart') as $id => $item)
            {{-- @dd($item) --}}
                <div class="relative border rounded-md p-2 mb-2 overflow-hidden group">
                    <img src="{{ $item['image'] }}" alt="Room Image" class="w-28 h-20 object-cover">
                    <h2 class="text-lg"><span class="font-semibold">{{ $item['hotel_name'] }}</span> {{ $item['name'] }}</h2>
                    <p>To {{ $item['checkin_date'] }} From {{ $item['checkout_date'] }}</p>
                    <p>${{ $item['price'] }}</p>
                    <form action="{{ route('cart.delete', ['id' => $item['id']]) }}" method="POST" class="absolute top-2 -right-10 group-hover:right-2 duration-150">
                        @csrf
                        <button type="submit" class="btn text-white bg-[#dc3545] hover:bg-[#bb2d3b]  rounded-full">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </form>
                </div>
            @endforeach

            <div class="absolute bottom-2 pr-6 w-full grid grid-cols-2 gap-2">
                <a href="/clear-cart" class="btn btn-danger w-full" style="margin-top: 10px;">
                    Delete All
                </a>
                <form action="/checkout" method="POST">
                    @csrf
                    <input type="hidden" name="cart" value="{{ json_encode(session('cart')) }}">
                    <button type="submit" class="btn text-white bg-[#0d6efd] hover:bg-[#0a58ca] w-full"
                        style="margin-top: 10px;">
                        Checkout
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
