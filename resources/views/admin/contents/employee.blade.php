@extends('admin')
@section('manager')
    <div class="container md:mx-auto ml-12 px-4 min-h-screen overflow-hidden">
        <h1 class="text-4xl py-8 font-bold leading-tight">All Employees</h1>
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
        {{-- <form action="{{ route('rooms.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword"
                    value="{{ request('keyword') }}">
                <button class="bg-white hover:bg-gray-100 text-gray-500 font-bold py-2 px-4 border border-gray-300 rounded"
                    type="submit">Search</button>
            </div>
        </form> --}}

        <!-- Button trigger modal -->
        <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Add Employees
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
                        <form id="submit-form" method="POST" action="{{ route('employee.create') }}"
                            enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="province_id" class="form-label">Hotel:</label>
                                <select name="province_id" id="province_id" class="form-control" required>
                                    <option value="">Select Hotel</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Name:</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="text" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label">Position:</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="position" id="Receptionist"
                                                value="Receptionist" required checked>
                                            <label class="form-check-label" for="Receptionist">Receptionist</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="position" id="Labor"
                                                value="Labor" required>
                                            <label class="form-check-label" for="Labor">Labor</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="position" id="Security"
                                                value="Security" required>
                                            <label class="form-check-label" for="Security">Security</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="position" id="Manager"
                                                value="Manager" required>
                                            <label class="form-check-label" for="Manager">Manager</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="salary" class="form-label">Salary:</label>
                                <input type="text" name="salary" id="salary" class="form-control" required>
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
        <table class="w-full my-3">
            <thead>
                <tr class="flex flex-wrap items-center justify-between border-b-2">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Hotel</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Position</th>
                            <th class="px-4 py-2">Salary</th>
                            {{-- <th class="px-4 py-2">Actions</th> --}}
                        </tr>
                    </thead>
                </tr>
            </thead>
            <tbody>

                @foreach ($employees as $employee)
                    <tr class="border">
                        <td class="px-4 py-2">{{ $employee->full_name }}</td>
                        <td class="border-l px-4 py-2">{{ $employee->hotel->name }}</td>
                        <td class="border-l px-4 py-2">{{ $employee->email }}</td>
                        <td class="border-l px-4 py-2">{{ $employee->position }}</td>
                        <td class="border-l px-4 py-2">{{ $employee->salary }}</td>
                        {{-- <td class="border-l px-4 py-2 flex gap-2">
                            <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white"
                                data-bs-toggle="modal" data-bs-target="#exampleModal{{ $employee->id }}">
                                Edit employee
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $employee->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="update-form{{ $employee->id }}"
                                                action="{{ route('employee.update', $employee->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')

                                                <div class="mb-3">
                                                    <label for="full_name" class="form-label">Name:</label>
                                                    <input type="text" name="full_name" id="full_name"
                                                        class="form-control" value=" {{ $employee->full_name }} "
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email:</label>
                                                    <input type="text" name="email" id="email"
                                                        class="form-control" value=" {{ $employee->email }} " required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="position" class="form-label">Position:</label>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="position" id="Receptionist"
                                                                    value="Receptionist" required
                                                                    @if ($employee->position == 'Receptionist') checked @endif>
                                                                <label class="form-check-label"
                                                                    for="Receptionist">Receptionist</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="position" id="Labor" value="Labor"
                                                                    required
                                                                    @if ($employee->position == 'Labor') checked @endif>
                                                                <label class="form-check-label"
                                                                    for="Labor">Labor</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="position" id="Security" value="Security"
                                                                    required
                                                                    @if ($employee->position == 'Security') checked @endif>
                                                                <label class="form-check-label"
                                                                    for="Security">Security</label>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="position" id="Manager" value="Manager"
                                                                    required
                                                                    @if ($employee->position == 'Manager') checked @endif>
                                                                <label class="form-check-label"
                                                                    for="Manager">Manager</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="salary" class="form-label">Salary:</label>
                                                    <input type="text" name="salary" id="salary"
                                                        class="form-control" value=" {{ $employee->salary }} " required>
                                                </div>

                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gray-300 hover:bg-gray-400 text-gray-800"
                                                data-bs-dismiss="modal">Close</button>
                                            <button id="update-button{{ $employee->id }}" type="button"
                                                class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('employee.delete', $employee->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn bg-red-500 hover:bg-red-700 text-white">Delete</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                {{ $employees->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
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

            @foreach ($employees as $employee)
                var updateButton{{ $employee->id }} = document.getElementById('update-button{{ $employee->id }}');
                updateButton{{ $employee->id }}.addEventListener('click', function() {
                    var form{{ $employee->id }} = document.getElementById('update-form{{ $employee->id }}');
                    if (form{{ $employee->id }}.checkValidity()) {
                        form{{ $employee->id }}.submit();
                    } else {
                        form{{ $employee->id }}.classList.add('was-validated');
                    }
                });
            @endforeach
        </script>
@endsection
