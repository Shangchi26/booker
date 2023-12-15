@extends('master')
@section('content')
    <h1 class="text-4xl font-bold text-center m-3"> {{ $room->hotel_name }}</h1>
    <div class="px-[10%]">
        <div class="w-full mx-auto mt-6">
            <div class="flex flex-col lg:flex-row -mx-4">
                <div class="md:flex-1 px-4 mb-5">
                    <div x-data="{ image: 1 }" x-cloak>
                        @if (count($room->images) > 0)
                            <div class="flex flex-col">
                                <img src="{{ $room->images[0] }}" alt="{{ $room->name }}"
                                    class="min-w-[300px] max-w-[700px] max-h-[400px] object-cover h-64 md:h-80 rounded-lg bg-gray-100 mb-4">
                                <div class="h-20 flex -mx-2 mb-4">
                                    @foreach ($room->images as $key => $images)
                                        <div class="flex-1 px-2">
                                            <button x-on:click="image = {{ $key + 1 }}"
                                                :class="{ 'ring-2 ring-indigo-300 ring-inset': image === {{ $key + 1 }} }"
                                                class="focus:outline-none w-full rounded-lg h-24 md:h-32 bg-gray-100 flex items-center justify-center">
                                                <img src="{{ $images }}" alt="{{ $room->name }}"
                                                    class="h-full w-full object-cover">
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="md:flex-1 px-4">
                    <h2 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">Room:
                        {{ $room->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $room->hotel_description }}</p>

                    <div class="flex items-center space-x-4 my-2">
                        <div>
                            <div class="rounded-lg bg-gray-100 flex py-2 px-3">
                                <span class="text-indigo-400 mr-1 mt-1">$</span>
                                <span class="font-bold text-indigo-600 text-3xl">{{ $room->price }} one Night</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm py-2">{{ $room->bookingCount }} Booking</p>
                    @if (count($room->amenities) > 0)
                        <ul class="md:flex md:flex-row grid grid-cols-3 gap-3">
                            @foreach ($room->amenities as $amenity)
                                <li
                                    class="btn hover:bg-indigo-600 border-indigo-500 rounded text-gray-500 hover:text-gray-100 duration-150 truncate">
                                    {{ $amenity }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="flex py-4 space-x-4">
                        <form action="{{ route('cart.add', ['id' => $room->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2 font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">
                                Add to Cart
                            </button>
                        </form>
                        <form action="{{ route('booking', $room->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2 font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">
                                Booking Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <iframe width="100%" height="450" frameborder="0" style="border:0"
            src="https://www.google.com/maps?q={{ $room->address }}&output=embed" allowfullscreen></iframe>
        <p class="my-2">My address: {{ $room->address }}</p>
        <p class="my-2">Contact: {{ $room->hotline }}</p>
        <div class="w-full grid grid-cols-2 bg-white border rounded-lg px-4 mb-10 pt-3">
            <form method="get" action="{{ route('review.search', ['id' => $room->id]) }}" class="flex items-start justify-around">
                <label for="rating">Filter by Rating:</label>
                    <select name="rating" id="rating"  class="font-bold rounded border-2 border-purple-700 text-gray-600 py-2 w-60 pl-3 pr-5 bg-white hover:border-gray-400 focus:outline-none appearance-none">
                        <option value="">All</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                <button type="submit" class="px-6 py-2 font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">Filter</button>
            </form>
            <div>
                @if ($room->reviews->isEmpty())
                @else
                <p>No reviews available.</p>
                    <h2>Have {{ $room->reviewCount }} reviews</h2>
                    <p>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $room->averageRating)
                                <i class="fa-solid fa-star" style="color: #ffdd44;"></i>
                            @else
                                <i class="fa-solid fa-star"></i>
                            @endif
                        @endfor stars
                        </h2>
                    <ul class="mx-[5%] my-5">
                        @foreach ($room->reviews as $review)
                            <li class="flex gap-3 pb-3">
                                <p class="font-semibold">{{ $review->user_name }}</p>
                                <div class="border-l pl-2">
                                    <p class="">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fa-solid fa-star" style="color: #ffdd44;"></i>
                                            @else
                                                <i class="fa-solid fa-star"></i>
                                            @endif
                                        @endfor
                                    </p>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js'></script>
@endsection
