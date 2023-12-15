@extends('employee')
@section('employee')
    <div class="container md:mx-auto ml-12 px-4 min-h-screen overflow-hidden">
        <h1 class="text-4xl py-8 font-bold leading-tight">{{ $room->name }} detail</h1>
        <div class="grid grid-cols-2 p-4 gap-4">
            @foreach ($room->amenities as $amenity)
                <div class="col-span-1">
                    <div class="pb-4">
                        <strong>{{ $amenity->name }}</strong>
                    </div>
                </div>
            @endforeach
            <div class="w-full grid grid-cols-4 gap-5">
                @foreach ($room->images as $image)
                    <div class="w-full h-2/3 object-cover">
                        <img src="{{ $image->image }}" alt="Room Image" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
