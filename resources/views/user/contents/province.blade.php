@extends('master')
@section('content')
    @php
        $today = now()->toDateString();
        $tomorrow = now()
            ->addDay()
            ->toDateString();
    @endphp
    <h1 class="text-4xl font-bold text-center m-3"> {{ $province->name }}</h1>
    <div class="container px-[10%]">
        @include('user.components.find')
        <div class="grid grid-cols-2 gap-3">
            @if (count($hotels) > 0)
                @foreach ($hotels as $hotel)
                    <a href="{{ route('hotel.show', $hotel->id) }}"
                        class="p-4 my-3 items-center justify-center w-full rounded-xl group sm:flex bg-white bg-opacity-50 shadow-xl hover:shadow-2xl duration-150">

                        <img class="mx-auto block w-4/12 h-40 rounded-lg" alt="{{ $hotel->name }}" loading="lazy"
                            src="{{ $hotel->image }}" />
                        <div class="sm:w-8/12 pl-0 p-5">
                            <div class="space-y-2">
                                <div class="space-y-4">
                                    <h4 class="text-xl font-semibold text-cyan-900 text-justify">
                                        {{ $hotel->name }}
                                    </h4>
                                </div>
                                <div class="flex items-center space-x-4 justify-between">
                                    <div class="flex gap-3 space-y-1">
                                        <span class="text-sm"> {{ $hotel->description }} </span>
                                    </div>

                                </div>
                                <div class="flex items-center space-x-4 justify-between">
                                    <div class="text-grey-500 flex flex-row space-x-1  my-4">
                                        <p class="text-sm">Have {{ $hotel->roomCount }} room available</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <p>No hotels found</p>
            @endif
        </div>
    </div>

    </div>
@endsection
