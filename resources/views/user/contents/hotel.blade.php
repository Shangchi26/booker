@extends('master')
@section('content')
    <h1 class="text-4xl font-bold text-center m-3">
        {{ $hotel->name }}</h1>
    <div class="container px-[10%] min-h-full">
        <div class="px-[10%]">
            {{-- <div class="flex flex-col gap-3">
                <label>
                    <input type="radio" value="1" class="peer hidden" name="filter">
                    <div
                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-3 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                        <h2 class="font-medium text-gray-700">5 Stars - Exceptional</h2>
                    </div>
                </label>

                <label>
                    <input type="radio" value="1" class="peer hidden" name="filter">
                    <div
                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-3 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                        <h2 class="font-medium text-gray-700">4 Start - Very good</h2>
                    </div>
                </label>
                <label>
                    <input type="radio" value="1" class="peer hidden" name="filter">
                    <div
                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-3 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                        <h2 class="font-medium text-gray-700">3 Start - Good</h2>
                    </div>
                </label>
                <label>
                    <input type="radio" value="1" class="peer hidden" name="filter">
                    <div
                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-3 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                        <h2 class="font-medium text-gray-700">2 Start - Normal</h2>
                    </div>
                </label>
                <label>
                    <input type="radio" value="1" class="peer hidden" name="filter">
                    <div
                        class="hover:bg-gray-50 flex items-center justify-between px-4 py-3 border-2 rounded-lg cursor-pointer text-sm border-gray-200 group peer-checked:border-blue-500">
                        <h2 class="font-medium text-gray-700">1 Start - Bad</h2>
                    </div>
                </label>
            </div> --}}
            <div class="items">
                @if (count($rooms) > 0)
                    @foreach ($rooms as $room)
                        <a href="{{ route('room.detail', ['id' => $room->id]) }}"
                            class="p-4 my-3 items-center justify-center w-full rounded-xl group sm:flex space-x-6 bg-white bg-opacity-50 shadow-xl hover:rounded-2xl">

                            <img class="mx-auto block w-4/12 h-40 rounded-lg" alt="{{ $room->name }}" loading="lazy"
                                src="{{ $room->image }}" />
                            <div class="sm:w-8/12 pl-0 flex flex-col">
                                <div class="space-y-2">
                                    <div class="space-y-4">
                                        <h4 class="text-md font-semibold text-cyan-900 text-justify">
                                            {{ $hotel->name }} {{ $room->name }}
                                        </h4>
                                    </div>
                                    <div class="flex items-center space-x-4 justify-between">
                                        <div class="flex gap-3 space-y-1">
                                            <span class="text-sm"> {{ $room->room_type }} </span>
                                        </div>

                                    </div>
                                    <div class="flex items-center space-x-4 justify-between">
                                        <div class="text-grey-500 flex flex-row space-x-1">
                                            <p class="text-xs">${{ $room->price }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex pt-4 space-x-4">
                                    <form action="{{ route('cart.add', ['id' => $room->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2 font-semibold text-xs rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">
                                            Add to Cart
                                        </button>
                                    </form>
                                    <form action="{{ route('booking', $room->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2 font-semibold text-xs rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">
                                            Booking Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p>No rooms available</p>
                @endif
            </div>
        </div>
    </div>
@endsection
