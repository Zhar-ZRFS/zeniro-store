<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeniro - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Pendaftaran Berhasil',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#005a8d',
                borderRadius: '2rem'
            });
        </script>
    @endif
</head>

<body class="antialiased font-sans">
    <img src="{{ asset('img/asset/login.jfif') }}" alt="Background"
        class="fixed inset-0 w-full h-full object-cover -z-10">
    <div class="relative min-h-screen w-full flex items-center">

        <div
            class="w-full max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start px-12 md:px-35 gap-10">

            <div class="flex flex-col items-start mt-4"> {{-- mt-4 buat fine-tuning biar presisi --}}
                <img src="{{ asset('img/logo/ZeniroWhiteBlue.png') }}" alt="ZENIRO Logo"
                    class="w-65 md:w-75 h-auto mb-2">
                <p class="text-white text-l md:text-lg font-light opacity-90 ml-2">Where Simplicity Meets Warmth</p>
            </div>

            <div
                class="bg-[#93c5fd]/30 backdrop-blur-2xl p-6 md:p-10 rounded-[2.5rem] w-full max-w-sm shadow-2xl border border-white/20">
                @yield('content')
            </div>

        </div>
    </div>
</body>

</html>