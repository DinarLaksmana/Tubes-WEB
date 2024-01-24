<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('https://unpkg.com/aos@next/dist/aos.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css') }}">
    @vite('resources/css/app.css')
    <title>Login | EduAssist</title>
    <link rel="shortcut icon" href="{{ asset('images/logo_umm.png') }}" type="image/x-icon" />
</head>

<body>
    <section class="flex overflow-hidden bg-cover bg-center" style="
          background-image: linear-gradient(
              rgba(0, 0, 0, 0.8),
              rgba(0, 0, 0, 0.8)
            ),
            url({{ asset('images/gkb4_umm.jpeg') }});
        ">
        <aside class="hidden md:flex md:w-[55%] 2md:w-[60%] lg:w-[65%]">
            <div class="flex flex-col items-center justify-center gap-7 -mt-16 md:px-14 lg:px-16">
                <img data-aos="zoom-in" src="{{ asset('images/logo_umm.png') }}" alt="Logo UMM" class="w-36" />
                <div class="text-white text-center font-medium md:text-sm lg:text-lg md:leading-[34px] lg:leading-8"
                    data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0">
                    EduAssist merupakan sistem layanan yang dirancang untuk
                    membantu dosen perguruan tinggi dalam mengelola tugas mahasiswa.
                </div>
            </div>
        </aside>
        <aside class="w-full relative md:w-[45%] 2md:w-[40%] lg:w-[35%] h-screen">
            <div class="flex flex-col items-center justify-center mx-auto">
                <div class="flex items-center justify-center h-screen w-full sm:max-w-md xl:p-0">
                    <div
                        class="flex justify-center mr-11 flex-col overflow-hidden w-full bg-white h-fit p-5 sm:p-8 rounded-lg">
                        <div class="mb-[25px] flex flex-col items-center justify-center gap-3 text-slate-900">
                            <img src="{{ asset('images/logo_umm.png') }}" alt="Logo UMM" class="w-[70px]" />
                            <p class="text-xl font-bold">Sign in to your account</p>
                        </div>
                        <form action="{{ route('login') }}" method="POST" class="space-y-4 md:space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="login-email"
                                    class="block mb-2 text-sm font-normal text-secondary">Email</label>
                                <input type="email" name="email" id="login-email"
                                    class="bg-gray-50 border border-gray-300 text-secondary sm:text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5"
                                    placeholder="example@webmail.umm.ac.id" required="" />
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-normal text-secondary">Password</label>
                                <input type="password" name="password" id="login-password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-secondary sm:text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5"
                                    required="" />
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="login-remember" aria-describedby="remember" type="checkbox"
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300" />
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="login-remember" class="text-secondary">Remember me</label>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="w-full text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-800 font-semibold rounded-lg text-sm px-5 py-2 text-center">
                                Sign in
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>
    </section>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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
    <script>
        AOS.init({
            duration: 1500,
        });
    </script>
</body>

</html>