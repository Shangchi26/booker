<!-- resources/views/rooms/index.blade.php -->

@extends('employee')

@section('employee')
    <div class="container md:mx-auto ml-12 px-4 min-h-screen overflow-hidden">
        <h1 class="text-4xl py-8 font-bold leading-tight">All Rooms</h1>
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

        <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Add Room
        </button>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Room</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="submit-form" method="POST" action="{{ route('room.create') }}"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="room_type" class="form-label">Type:</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="room_type"
                                                id="single_room_type" value="Single Room">
                                            <label class="form-check-label" for="single_room_type">Single Room</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="room_type"
                                                id="double_room_type" value="Double Room">
                                            <label class="form-check-label" for="double_room_type">Double Room</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="form-control" id="image" name="file" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="amenity" class="form-label">Amenities:</label>
                                <div class="grid grid-cols-3">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity" id="BreakFast"
                                                value="BreakFast">
                                            <label for="BreakFast" class="form-check-label">BreakFast</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Air-Conditioning" value="Air Conditioning">
                                            <label for="Air-Conditioning" class="form-check-label">Air Conditioning</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity" id="Bath-Tub"
                                                value="Bath Tub">
                                            <label for="Bath-Tub" class="form-check-label">Bath Tub</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity" id="Garage"
                                                value="Garage">
                                            <label for="Garage" class="form-check-label">Garage</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Pool" value="Pool">
                                            <label for="Pool" class="form-check-label">Pool</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Bar" value="Bar">
                                            <label for="Bar" class="form-check-label">Bar</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Internet" value="Internet">
                                            <label for="Internet" class="form-check-label">Internet</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Toilet Faucet" value="Toilet Faucet">
                                            <label for="Toilet Faucet" class="form-check-label">Toilet Faucet</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenity"
                                                id="Love Chair Sofa" value="Love Chair Sofa">
                                            <label for="Love Chair Sofa" class="form-check-label">Love Chair Sofa</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input type="text" name="price" id="price" class="form-control" required>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-400 hover:bg-gray-600 text-white"
                            data-bs-dismiss="modal">Close</button>
                        <button id="submit-button" type="button"
                            class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">Create Room</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="w-full">
            <thead>
                <tr class="flex flex-wrap items-center justify-between border-b-2">
                    <th class="w-1/4 md:w-1/5">Name</th>
                    <th class="w-1/4 md:w-1/5">Type</th>
                    <th class="w-1/4 md:w-1/5">Price</th>
                    <th class="w-1/4 md:w-1/5">Available</th>
                    <th class="md:block w-1/5 hidden">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="flex flex-wrap items-center justify-between border-b py-1">
                        <td class="w-1/4 md:w-1/5">{{ $room->name }}</td>
                        <td class="w-1/4 md:w-1/5">{{ $room->room_type }}</td>
                        <td class="w-1/4 md:w-1/5">{{ $room->price }}</td>
                        <td class="w-1/4 md:w-1/5">
                            @if ($room->available == 1)
                                <span class="text-green-600">Available</span>
                            @else
                                <span class="text-red-500">Nonavailable</span>
                            @endif
                        </td>
                        <td class="md:block w-full md:w-1/5 grid grid-cols-3">

                            <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white"
                                data-bs-toggle="modal" data-bs-target="#exampleModal{{ $room->id }}">
                                Edit Room
                            </button>
                            <form method="POST" action="{{ route('room.delete', $room->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn text-white bg-red-500 hover:bg-red-700"
                                    onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                            </form>
                            <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white"
                                data-bs-toggle="modal" data-bs-target="#Detail{{ $room->id }}">
                                Detail
                            </button>
                            <div class="modal fade" id="Detail{{ $room->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="border-b pb-3">
                                                <h3 class="text-lg mb-2">Amenities in room:</h3>
                                                <ul class="flex flex-wrap gap-2">
                                                    @foreach ($amenities[$room->id] as $amenity)
                                                        <li
                                                            class="flex flex-wrap btn btn-outline-primary gap-2 group cursor-default">
                                                            {{ $amenity->name }}
                                                            <form method="POST"
                                                                action="{{ route('amenity.delete', $amenity->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-danger hidden group-hover:inline-block cursor-pointer"><i
                                                                        class="fa-regular fa-trash-can"></i></button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="py-3 border-b">
                                                <h2 class="text-lg mb-2">Missing Amenities:</h2>
                                                <ul class="flex flex-wrap gap-2">
                                                    @foreach ($enumAmenities as $enumAmenity)
                                                        @if (!in_array($enumAmenity, $amenities[$room->id]->pluck('name')->toArray()))
                                                            <li
                                                                class="btn btn-outline-secondary flex flex-wrap gap-2 group cursor-default">
                                                                {{ $enumAmenity }}
                                                                <form action="{{ route('amenity.add', $room->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <label class="hidden">
                                                                        <input type="text" name="name"
                                                                            value="{{ $enumAmenity }}">
                                                                    </label>
                                                                    <button type="submit"
                                                                        class="text-primary hidden group-hover:inline-block cursor-pointer"><i
                                                                            class="fa-solid fa-plus"></i></button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="py-3">
                                                <h2 class="text-lg mb-2">Images: </h2>
                                                <div class="grid grid-cols-3 gap-2">
                                                    @if (isset($images[$room->id]))
                                                        @foreach ($images[$room->id] as $image)
                                                            <div class="h-28 relative overflow-hidden group">
                                                                <img src="{{ asset($image->image) }}" alt="Room Image"
                                                                    class="h-full object-cover rounded">
                                                                <form action="{{ route('image.delete', $image->id) }}"
                                                                    method="POST"
                                                                    class="absolute top-2 -right-10 group-hover:right-2 duration-150">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        class="btn  text-white bg-[#dc3545] hover:bg-[#bb2d3b]  rounded-full">
                                                                        <i class="fa-solid fa-x"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <form id="imageForm{{ $room->id }}"
                                                        action="{{ route('image.add') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $room->id }}">
                                                        <label for="input{{ $room->id }}"
                                                            class="w-full h-28 cursor-pointer flex justify-center items-center rounded bg-slate-200 hover:bg-slate-300 duration-150">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </label>
                                                        <input type="file" name="image" accept="image/*" multiple
                                                            class="hidden" id="input{{ $room->id }}"
                                                            onchange="submitForm('{{ $room->id }}')" />
                                                    </form>
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

                            <div class="modal fade" id="exampleModal{{ $room->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="update-form{{ $room->id }}"
                                                action="{{ route('room.update', $room->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" value="{{ $room->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price:</label>
                                                    <input type="text" class="form-control" id="price"
                                                        name="price" value="{{ $room->price }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="room_type" class="form-label">Type:</label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="room_type" id="single_room_type"
                                                                    value="Single Room" required <?php if ($room->room_type == 'Single Room') {
                                                                        echo 'checked';
                                                                    } ?>>
                                                                <label class="form-check-label"
                                                                    for="single_room_type">Single Room</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="room_type" id="double_room_type"
                                                                    value="Double Room" required <?php if ($room->room_type == 'Double Room') {
                                                                        echo 'checked';
                                                                    } ?>>
                                                                <label class="form-check-label"
                                                                    for="double_room_type">Double Room</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="available" class="form-label">Available:</label>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="available" id="available" value="1"
                                                                        required <?php if ($room->available == 1) {
                                                                            echo 'checked';
                                                                        } ?>>
                                                                    <label class="form-check-label"
                                                                        for="available">Available</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="available" id="nonavailable" value="0"
                                                                        required <?php if ($room->available == 0) {
                                                                            echo 'checked';
                                                                        } ?>>
                                                                    <label class="form-check-label"
                                                                        for="nonavailable">Nonavailable</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gray-400 hover:bg-gray-600 text-white"
                                                data-bs-dismiss="modal">Close</button>
                                            <button id="update-button{{ $room->id }}" type="button"
                                                class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                {{ $rooms->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
            </ul>
        </nav>
    </div>

    <script>
        document.getElementById('submit-button').addEventListener('click', function() {
            var form = document.getElementById('submit-form');
            if (form.checkValidity()) {
                form.submit();
            } else {
                form.classList.add('was-validated');
            }
        });

        @foreach ($rooms as $room)
            var updateButton{{ $room->id }} = document.getElementById('update-button{{ $room->id }}');
            updateButton{{ $room->id }}.addEventListener('click', function() {
                var form{{ $room->id }} = document.getElementById('update-form{{ $room->id }}');
                if (form{{ $room->id }}.checkValidity()) {
                    form{{ $room->id }}.submit();
                } else {
                    form{{ $room->id }}.classList.add('was-validated');
                }
            });
        @endforeach
        function submitForm(roomId) {
            var form = document.getElementById('imageForm' + roomId);
            form.submit();
        }
    </script>

@endsection
