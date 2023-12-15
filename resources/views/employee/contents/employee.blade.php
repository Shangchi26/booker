@extends('employee')
@section('employee')
    <div class="container">
        <div class="container mx-auto px-4 min-h-screen">
            <h1 class="text-4xl py-8 font-bold leading-tight">All employees</h1>
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

            {{-- <form action="{{ route('employees.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form> --}}

            <!-- Button trigger modal -->
            <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add employee
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Upload employee</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="submit-form" method="POST" action="{{ route('employee.create') }}"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Name:</label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" name="email" id="email" class="form-control" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="text" name="password" id="password" class="form-control" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="position" class="form-label">Position:</label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="position"
                                                    id="Receptionist" value="Receptionist" required checked>
                                                <label class="form-check-label" for="Receptionist">Receptionist</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="position"
                                                    id="Labor" value="Labor" required>
                                                <label class="form-check-label" for="Labor">Labor</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="position"
                                                    id="Security" value="Security" required>
                                                <label class="form-check-label" for="Security">Security</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="position"
                                                    id="Manager" value="Manager" required>
                                                <label class="form-check-label" for="Manager">Manager</label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary:</label>
                                    <input type="text" name="salary" id="salary" class="form-control" required>
                                    @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="submit-button" type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white">Create employee</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->full_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->salary }}</td>
                            <td>

                                <button type="button" class="btn bg-[#0d6efd] hover:bg-blue-700 text-white" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $employee->id }}">
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
                                                            class="form-control" value=" {{ $employee->email }} "
                                                            required>
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
                                                            class="form-control" value=" {{ $employee->salary }} "
                                                            required>
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
                                <form method="POST" action="{{ route('employee.delete', $employee->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn text-white bg-red-500 hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <nav>
                {{-- <ul class="pagination justify-content-center">
                {{ $employees->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
            </ul> --}}
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
