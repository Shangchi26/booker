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
        {{-- <form action="{{ route('hotel.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form> --}}

        <!-- Button trigger modal -->
        <button type="button" class="btn px-10 bg-[#0d6efd] hover:bg-[#0b5ed7] text-white duration-150" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Hotel
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Upload Admin</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="submit-form" method="POST" action="{{ route('admin.create') }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Name:</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_name" class="form-label">User Name:</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
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
        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>User Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->full_name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->user_name }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
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
    </script>
@endsection
