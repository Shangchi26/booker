<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!-- component -->
<div class="min-h-screen bg-gray-100 flex flex-col justify-center sm:py-12">
    <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
        <h1 class="font-bold text-center text-2xl mb-5">Employee Booker</h1>
        <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
            <div class="px-5 py-7">
                <form action="/employee/login" method="POST">
                    @csrf
                    <label class="font-semibold text-sm text-gray-600 pb-1 block">Email</label>
                    <input type="text" name="email"
                        class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                    <label class="font-semibold text-sm text-gray-600 pb-1 block">Password</label>
                    <input type="password" name="password"
                        class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
                    @if (isset($error))
                        <div style="color: red;">
                            {{ $error }}
                        </div>
                    @endif
                    <button type="submit"
                        class="transition duration-200 bg-blue-500 hover:bg-blue-600 focus:bg-blue-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
