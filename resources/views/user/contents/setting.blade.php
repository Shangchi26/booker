@extends('master')
@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-2">
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
    <div class="md:grid grid-cols-4  gap-2 pt-20 px-[10%] rounded-xl min-h-[80vh]">
        <div class="md:col-span-1 h-56 py-3 shadow-xl ">
            <div class="flex w-full h-full relative">
                <img src="https://res.cloudinary.com/dboafhu31/image/upload/v1625318266/imagen_2021-07-03_091743_vtbkf8.png"
                    class="w-44 h-44 m-auto" alt="">

            </div>
        </div>
        <div class="md:col-span-3 h-56 py-3 shadow-xl px-4 space-y-2">
            <form action="{{ route('user.update') }}" method="POST">
                @csrf
                <label class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <div class="flex">

                    <input type="text" value="{{ $user->full_name }}" name="full_name"
                        class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                <div class="flex">

                    <input type="text" value="{{ $user->user_name }}" name="user_name"
                        class="rounded-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm border-gray-300 p-2.5 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button type="submit" class="btn bg-blue-500 hover:bg-blue-600 text-white mt-3">Submit</button>
                <button type="button" class="btn bg-blue-500 hover:bg-blue-600 text-white mt-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Change Password
                </button>
            </form>

        </div>
        <div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('password.change') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="mb-3">
                                    <label for="opassword" class="form-label">Now Password:</label>
                                    <input type="password" name="old_password" id="opassword" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="npassword" class="form-label">New Password:</label>
                                    <input type="password" name="new_passsword" id="npasssword" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
