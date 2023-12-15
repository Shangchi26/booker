<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- component -->
<div class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
    <div class="w-1/2 h-screen hidden lg:block">
        <img src="https://res.cloudinary.com/dx2o9ki2g/image/upload/v1698233800/xe6uu3wxnfj2xaufj3co.webp" alt="Placeholder Image"
            class="object-cover w-full h-full">
    </div>
    <!-- Right: Login Form -->
    <div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
        <h1 class="text-2xl font-semibold mb-4">Login</h1>
        <form action="/login" method="POST">
            @csrf
            <!-- Username Input -->
            <div class="mb-4">
                <label for="user_name" class="block text-gray-600">Username</label>
                <input type="text" id="user_name" name="user_name"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                    autocomplete="off">
            </div>
            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500"
                    autocomplete="off">
            </div>
            @if (isset($error))
                <div style="color: red;">
                    {{ $error }}
                </div>
            @endif

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
        </form>
        <!-- Sign up  Link -->
        <div class="mt-6 text-blue-500 text-center">
            <a href="/register" class="hover:underline">Sign up Here</a>
        </div>
    </div>
</div>
