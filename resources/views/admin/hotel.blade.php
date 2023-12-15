@extends('admin')

@section('manager')
    <div class="container pt-5">
        <h1 class="text-3xl font-bold">All Hotels</h1>
        {{-- {{ $admin->email }} --}}
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
        <form action="{{ route('hotel.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <!-- Button trigger modal -->
        <button type="button" class="btn px-10 bg-[#0d6efd] hover:bg-[#0b5ed7] text-white duration-150" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Hotel
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Hotel</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="submit-form" method="POST" action="{{ route('hotel.create') }}"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="province_id" class="form-label">Province:</label>
                                <select name="province_id" id="province_id" class="form-control" required>
                                    <option value="">Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" name="address" id="address" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="hotline" class="form-label">Hotline:</label>
                                <input type="text" name="hotline" id="hotline" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="submit-button" type="button" class="btn btn-primary">Create Hotel</button>
                    </div>
                </div>
            </div>
        </div>
        <table class="w-full my-3">
            <thead>
                <tr class="items-center border-b-2">
                    <th>Name</th>
                    <th>Province</th>
                    <th>Image</th>
                    <th>Address</th>
                    <th>Hotline</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotels as $hotel)
                    <tr class="border">
                        <td class="px-4 py-2">{{ $hotel->name }}</td>
                        <td class="border-l px-4 py-2">{{ $hotel->province_name }}</td>
                        <td class="border-l px-4 py-2"><img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-24 h-12 object-cover"></td>
                        <td class="border-l px-4 py-2">{{ $hotel->address }}</td>
                        <td class="border-l px-4 py-2">{{ $hotel->hotline }}</td>
                        <td class="border-l px-4 py-2">{{ $hotel->description }}</td>
                        <td class="flex gap-3">

                            <button type="button" class="truncate btn px-2 bg-[#0d6efd] hover:bg-[#0b5ed7] text-white duration-150" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $hotel->id }}">
                                Edit Hotel
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $hotel->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="update-form{{ $hotel->id }}"
                                                action="{{ route('hotel.update', $hotel->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')

                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" value="{{ $hotel->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="province_id" class="form-label">Province:</label>
                                                    <select class="form-control" id="province_id" name="province_id"
                                                        required>
                                                        @foreach ($provinces as $province)
                                                            <option value={{ $province->id }}
                                                                {{ $hotel->province_id == $province->id ? 'selected' : '' }}>
                                                                {{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Image:</label>
                                                    <input type="file" class="form-control" id="image"
                                                        name="image" accept="image/*">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address:</label>
                                                    <input type="text" class="form-control" id="address"
                                                        name="address" value="{{ $hotel->address }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="hotline" class="form-label">Hotline:</label>
                                                    <input type="text" class="form-control" id="hotline"
                                                        name="hotline" value="{{ $hotel->hotline }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Description:</label>
                                                    <textarea class="form-control" id="description" name="description" required>{{ $hotel->description }}</textarea>
                                                </div>


                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button id="update-button{{ $hotel->id }}" type="button"
                                                class="btn btn-primary">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('hotels.delete', $hotel->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn px-2 bg-red-600 hover:bg-red-800 text-white duration-150"
                                    onclick="return confirm('Are you sure you want to delete this hotel?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                {{ $hotels->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
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

        @foreach ($hotels as $hotel)
            var updateButton{{ $hotel->id }} = document.getElementById('update-button{{ $hotel->id }}');
            updateButton{{ $hotel->id }}.addEventListener('click', function() {
                var form{{ $hotel->id }} = document.getElementById('update-form{{ $hotel->id }}');
                if (form{{ $hotel->id }}.checkValidity()) {
                    form{{ $hotel->id }}.submit();
                } else {
                    form{{ $hotel->id }}.classList.add('was-validated');
                }
            });
        @endforeach
    </script>
@endsection
