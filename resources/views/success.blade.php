<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Password reset</title>
</head>
<body>
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <img class="mx-auto h-56 w-auto" src="{{ asset('logo.png') }}"
                 alt="Workflow">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Server response!
            </h2>
        </div>
        @if(session()->has('success'))
            <p>{{ session('success') }}</p>
        @endif

        <form class="mt-8 space-y-6" method="POST">
            @csrf
            <input type="hidden" name="remember" value="true">
            <div>
                <a class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                   href="{{ config('app.web_app_url') }}">Goto Dashboard</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
