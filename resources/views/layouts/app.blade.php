<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('images/logo_umm.png') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>@yield('title')</title>
</head>

<body>
    <div class="relative max-w-4xl mx-auto">
        <div class="absolute w-16 h-16 rounded-full bg-rose-600 top-0 right-48 z-0"></div>
        <header
            class="flex items-center justify-between py-2 border-b border-gray-200 sticky top-0 bg-white bg-clip-padding bg-opacity-20 z-50"
            style="backdrop-filter: blur(40px)">
            <a href="" class="flex gap-2 items-center">
                <img src="{{ asset('images/logo_umm.png') }}" alt="Logo UMM" class="h-10" />
                <div class="">
                    <h1 class="font-bold text-lg">EduAssist</h1>
                    <div class="text-xs">Sistem Penunjang Tugas Dosen</div>
                </div>
            </a>
            <div class="font-bold text-xl">Selamat Datang</div>
            <!-- Kondisi jika auth tidak kosong -->
            @if(Auth::check())
            <div class="flex items-center">
                <div class="inline-block text-left">
                    <div class="group relative cursor-pointer flex gap-2 py-3">
                        <div class="hidden h-9 relative md:flex flex-col justify-between items-end pl-3">
                            <div class="text-secondary md:w-40 lg:w-auto text-sm font-medium md:truncate md:break-all">
                                {{ Auth::user()->name }}
                            </div>
                            @if (Auth::user()->type == 'dosen')
                            <p class="text-red-700 text-xs font-semibold">Dosen</p>
                            @else
                            <p class="text-green-700 text-xs font-semibold">Mahasiswa</p>
                            @endif
                        </div>
                        <ion-icon name="chevron-down-outline" class="md:hidden place-self-center"></ion-icon>
                        <img src="{{ asset('images/profile.webp') }}" alt="profile" class="w-8 h-8 rounded-full" />
                        <div class="absolute hidden group-hover:block animate__animated animate__fadeIn animate__faster right-0 z-50 mt-11 w-56 origin-top-right rounded-md bg-white shadow-lg border border-gray-200 focus:outline-none"
                            id="profileDropdown">
                            <div class="py-1">
                                <form method="POST" id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    <button
                                        class="flex items-center gap-2 text-gray-700 hover:bg-gray-100 w-full px-4 py-2 mt-1 text-left text-sm"
                                        role="menuitem" tabindex="-1">
                                        <ion-icon name="log-out-outline"></ion-icon>
                                        <p>Sign out</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </header>
        @yield('content')
    </div>
    @yield('modal')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @stack('scripts')
    @if (Session:: has('success'))
    <script>
        Toastify({
            text: "{{ Session::get('success') }}",
            duration: 3000,
            newWindow: true,
            gravity: 'bottom',
            position: 'center',
            stopOnFocus: true,
            style: {
                background: '#16a34a',
                borderRadius: '6px',
            },
            onClick: function () { },
        }).showToast();
    </script>
    @endif

    @if (Session:: has('error'))
    <script>
        Toastify({
            text: "{{ Session::get('error') }}",
            duration: 3000,
            newWindow: true,
            gravity: 'bottom',
            position: 'center',
            stopOnFocus: true,
            style: {
                background: '#E74C3C',
                borderRadius: '6px',
            },
            onClick: function () { },
        }).showToast();
    </script>
    @endif
</body>

</html>