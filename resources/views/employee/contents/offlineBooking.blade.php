@extends('employee')
@section('employee')
    <div class="container md:mx-auto ml-12 px-4 min-h-screen overflow-hidden">
        <h1 class="text-4xl py-8 font-bold leading-tight">Booking</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Available</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($rooms as $room)
                    <tr>
                        <td class="border px-4 py-2">{{ $room->name }}</td>
                        <td class="border px-4 py-2">
                            {{ $room->room_type }}
                        </td>
                        <td class="border px-4 py-2">{{ $room->price }}</td>
                        <td class="border px-4 py-2">
                            @if ($roomAvailability[$room->id] && $room->available == 1)
                                <span class="text-green-500">Available</span>
                            @else
                                <span class="text-red-500">Not Available</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2 flex gap-2">
                            <form action="{{ route('booking.offline', $room->id) }}">
                                @csrf
                                <button class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">Booking</button>
                            </form>
                            <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white"
                                data-bs-toggle="modal" data-bs-target="#detail_{{ $room->id }}">
                                Detail
                            </button>
                            <div class="modal fade" id="detail_{{ $room->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $room->name }} Details
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="border-b pb-3">
                                                <h2 class="text-lg mb-2">Amenities:</h2>
                                                <ul class="flex flex-wrap gap-2">
                                                    @foreach ($room->amenities as $amenity)
                                                        <li class="flex flex-wrap btn btn-outline-primary gap-2">
                                                            {{ $amenity->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="py-3">
                                                <h2 class="text-lg mb-2">Images:</h2>
                                                <div class="grid grid-cols-3 gap-2">
                                                    @foreach ($room->images as $image)
                                                        <div class="h-28">
                                                            <img src="{{ $image->image }}" alt="Room Image"
                                                                class="h-full object-cover rounded">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gray-400 hover:bg-gray-600 text-white"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
