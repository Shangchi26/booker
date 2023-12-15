@extends('admin')

@section('manager')
    <div class="container">
        <h1>All Rooms</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- <form action="{{ route('rooms.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form> --}}

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Room
        </button>

        <!-- Modal -->
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
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hotel_id" class="form-label">Hotel:</label>
                                <select name="hotel_id" id="hotel_id" class="form-control" required>
                                    <option value="">Select Hotel</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                                @error('hotel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_type" class="form-label">Type:</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="room_type"
                                                id="single_room_type" value="Single Room" required>
                                            <label class="form-check-label" for="single_room_type">Single Room</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="room_type"
                                                id="double_room_type" value="Double Room" required>
                                            <label class="form-check-label" for="double_room_type">Double Room</label>
                                        </div>
                                    </div>
                                </div>
                                @error('room_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price:</label>
                                <input type="text" name="price" id="price" class="form-control" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="submit-button" type="button" class="btn btn-primary">Create Room</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Hotel</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Amenities</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->hotel_name }}</td>
                        <td>{{ $room->room_type }}</td>
                        <td>{{ $room->price }}</td>
                        <td>
                            @foreach ($amenities->where('room_id', $room->id) as $amenity)
                                {{ $amenity->amenities_list }}
                            @endforeach
                        </td>
                        <td>
                            @if ($room->available == 1)
                                Available
                            @else
                                Nonavailable
                            @endif
                        </td>
                        <td>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $room->id }}">
                                Edit Room
                            </button>

                            <!-- Modal -->
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
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="hotel_id" class="form-label">Hotel:</label>
                                                    <select class="form-control" id="hotel_id" name="hotel_id" required>
                                                        @foreach ($hotels as $hotel)
                                                            <option value={{ $hotel->id }}
                                                                {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                                                                {{ $hotel->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('hotel_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price:</label>
                                                    <input type="text" class="form-control" id="price"
                                                        name="price" value="{{ $room->price }}" required>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                                                    @error('room_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                                                    @error('available')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button id="update-button{{ $room->id }}" type="button"
                                                class="btn btn-primary">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('rooms.delete', $room->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this room?')">Delete</button>
                            </form>
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
    </script>
@endsection
