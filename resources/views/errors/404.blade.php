<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('images/logo_umm.png') }}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css') }}">
    @vite('resources/css/app.css')
    <title>Not Found</title>
</head>

<body>
    <section class="bg-white flex max-w-6xl h-screen mx-auto">
        <div class="py-8 px-4 mx-auto w-[60%] lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center">
                <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-sky-600 ">
                    404</h1>
                <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl e">Opsss...</p>
                <p class="mb-4 text-base font-light text-gray-500">Maaf, halaman yang anda kunjungi
                    tidak ditemukan.
                    Untuk kembali ke halaman sebelumnya, tekan tombol kembali di bawah. </p>
                <button onclick="window.history.back();"
                    class="inline-flex text-white bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">Kembali</button>
            </div>
        </div>
        <div class="flex w-[40%] self-end justify-start">
            <img src="{{ asset('images/404.gif') }}" alt="Not Found" class="w-full">
        </div>
    </section>
</body>

</html>