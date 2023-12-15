@extends('admin')

@section('manager')
    <div class="container pt-5">
        <h1 class="text-3xl font-bold">All Users</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- <form action="{{ route('user.search') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search" name="keyword" value="{{ request('keyword') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>User Name</th>
                    <th>Point</th>
                    <th>Verify</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->point }}</td>
                        <td>{{ $user->is_verify }}</td>
                        <td class="flex gap-3">
                            <form method="POST" action="{{ route('user.delete', $user->id) }}"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn px-2 bg-red-600 hover:bg-red-800 text-white duration-150"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center">
                {{ $users->onEachSide(2)->appends(Request::query())->links('pagination::bootstrap-4') }}
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

        @foreach ($users as $user)
            var updateButton{{ $user->id }} = document.getElementById('update-button{{ $user->id }}');
            updateButton{{ $user->id }}.addEventListener('click', function() {
                var form{{ $user->id }} = document.getElementById('update-form{{ $user->id }}');
                if (form{{ $user->id }}.checkValidity()) {
                    form{{ $user->id }}.submit();
                } else {
                    form{{ $user->id }}.classList.add('was-validated');
                }
            });
        @endforeach
    </script>
@endsection
