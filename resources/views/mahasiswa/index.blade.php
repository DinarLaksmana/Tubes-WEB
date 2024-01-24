@extends('layouts.app')

@section('title', 'Mahasiswa | Dashboard')

@section('content')
<main class="bg-white bg-clip-padding bg-opacity-60 z-50 my-8" style="backdrop-filter: blur(40px)">
    <!-- task section -->
    <section>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Daftar Tugas</h1>
            @if (count($tasks) > 0)
            <div class="font-semibold">Nilai Rata-Rata :
                @if (number_format($averageScore, 0) >= 80)
                <span class="text-green-700">{{ number_format($averageScore, 0) }}</span>
                @elseif (number_format($averageScore, 0) >= 55)
                <span class="text-yellow-700">{{ number_format($averageScore, 0)
                    }}</span>
                @else
                <span class="text-red-700">{{ number_format($averageScore, 0) }}</span>
                @endif
            </div>
            @endif
        </div>
        @if (count($tasks) > 0)
        <div class=" mt-6 space-y-2">
            <p class="text-sm font-semibold">Keterangan :</p>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                </span>
                <span class="text-xs text-slate-800">:</span>
                <span class="text-xs text-slate-800"><span class="italic underline underline-offset-2">Sudah</span>
                    Mengumpulkan</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                <span class="text-xs text-slate-800">:</span>
                <span class="text-xs text-slate-800"><span class="italic underline underline-offset-2">Belum</span>
                    Mengumpulkan</span>
            </div>
        </div>
        <div class="space-y-4 mt-4">
            @foreach ($tasks as $index => $task)
            @php
            $themes = ['classroom', 'student', 'teacher', 'education'];
            $themeIndex = $index % count($themes);
            $theme = $themes[$themeIndex];
            @endphp
            <div
                class="relative flex rounded-xl bg-white border border-gray-200 bg-clip-border text-gray-700 shadow-lg">
                <div
                    class="relative mx-4 my-4 overflow-hidden text-white shadow-lg rounded-xl bg-blue-gray-500 bg-clip-border shadow-blue-gray-500/40 w-1/2">
                    <img src="https://source.unsplash.com/random/900x500/?{{ $theme }}"
                        class="object-cover w-full h-full" alt="ui/ux review check" />
                    <div
                        class="absolute inset-0 w-full h-full to-bg-black-10 bg-gradient-to-tl from-transparent via-transparent to-black/80">
                    </div>
                    @if ($task->status == 'active')
                    <span
                        class="!absolute  top-4 left-4 bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Dibuka</span>
                    @else
                    <span
                        class="!absolute  top-4 left-4 bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">Ditutup</span>
                    @endif
                </div>
                <div class="flex flex-col justify-between w-1/2">
                    <div class="p-6 !pt-3">
                        <div class="flex items-start justify-between mb-3 gap-2">
                            <h5 class="block text-xl antialiased leading-snug tracking-normal text-slate-800 font-bold">
                                {{ $task->title }}
                            </h5>
                            @if (!$task->users->contains(auth()->id()))
                            <span class="relative flex h-3 w-3 mt-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                            </span>
                            @else
                            <span class="relative flex h-3 w-3 mt-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                            </span>
                            @endif
                        </div>
                        <div class="flex items-center {{ $task->file ? 'justify-between' : 'justify-start' }}">
                            @if ($task->file)
                            <div class="flex items-center gap-1">
                                <a href="{{ asset('storage/' . $task->file) }}"
                                    class="download-button transform active:scale-95 bg-sky-700 hover:bg-sky-600 text-white px-3 py-1.5 rounded-[4px] font-semibold"
                                    target="_blank" download>
                                    <div class="flex justify-center items-center relative">
                                        <div class="svg-container">
                                            <!-- Download Icon -->
                                            <svg class="download-icon" width="10" height="14" viewBox="0 0 18 22"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path class="download-arrow" d="M13 9L9 13M9 13L5 9M9 13V1"
                                                    stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M1 17V18C1 18.7956 1.31607 19.5587 1.87868 20.1213C2.44129 20.6839 3.20435 21 4 21H14C14.7956 21 15.5587 20.6839 16.1213 20.1213C16.6839 19.5587 17 18.7956 17 18V17"
                                                    stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="pl-2 !leading-none text-xs">Download Lampiran</div>
                                    </div>
                                </a>
                                <div class="flex items-center">
                                    <ion-icon data-tooltip-target="tooltip-light{{ $task->id }}"
                                        data-tooltip-style="light" name="information-circle-outline"
                                        class="w-5 h-5 leading-none"></ion-icon>
                                    <div id="tooltip-light{{ $task->id }}" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-gray-900 bg-gray-100 border border-gray-400 rounded-lg shadow-sm opacity-0 tooltip">
                                        Lampiran merupakan file tugas yang diunggah oleh dosen.
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="font-semibold text-sm">Nilai :
                                @php
                                $submittedTask = $task->users()->where('user_id', auth()->id())->first();
                                @endphp
                                @if ($submittedTask)
                                @if ($submittedTask->pivot->nilai >= 80)
                                <span class="text-green-700 font-bold">{{ $submittedTask->pivot->nilai }}</span>
                                @elseif ($submittedTask->pivot->nilai >= 55)
                                <span class="text-yellow-700 font-bold">{{ $submittedTask->pivot->nilai
                                    }}</span>
                                @else
                                <span class="text-red-700 font-bold">{{ $submittedTask->pivot->nilai }}</span>
                                @endif
                                @else
                                <span class="font-bold">-</span>
                                @endif</span>
                            </div>
                        </div>
                        <div class="text-slate-800 font-semibold text-sm mb-1 mt-3">Deskripsi :</div>
                        <p
                            class="block text-sm antialiased font-light leading-relaxed text-gray-700 max-h-44 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-400 scrollbar-track-slate-100 scrollbar-thumb-rounded-full scrollbar-track-rounded-full">
                            {{ $task->description }}
                        </p>
                    </div>
                    @if ($task->status == 'active')
                    @if (!$task->users->contains(auth()->id()))
                    <div class="bg-yellow-50 border border-yellow-200 text-sm text-yellow-800 rounded-lg p-4 mx-6"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="flex-shrink-0 h-3 w-3 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                    <path d="M12 9v4" />
                                    <path d="M12 17h.01" />
                                </svg>
                            </div>
                            <div class="ms-4">
                                <h3 class="text-xs font-semibold">
                                    Informasi
                                </h3>
                                <div class="mt-1 text-xs text-yellow-700">
                                    Anda hanya dapat mengumpulkan tugas 1 kali saja dan tidak bisa diubah.
                                    Jadi,
                                    pastikan file yang diunggah sudah benar sebelum mengumpulkan tugas.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <form action="{{ route('submitTask', $task->id) }}" method="post" enctype="multipart/form-data"
                            class="flex gap-2">
                            @csrf
                            <div>
                                <label for="task_file_input" class="sr-only cursor-pointer">Pilih File</label>
                                <input type="file" name="task_file" id="task_file_input" class="block w-full border cursor-pointer border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none 
                                        file:bg-gray-50 file:border-0 file:me-4
                                        file:py-2 file:px-4">
                            </div>
                            <button type="submit"
                                class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sky-600 text-white hover:bg-sky-700 disabled:opacity-50 disabled:pointer-events-none active:scale-95">
                                Submit
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="p-6 pt-3">
                        <a href="{{ asset('storage/' . $task->users()->where('user_id', auth()->id())->first()->pivot->file_path) }}"
                            class="block w-full select-none rounded-lg bg-gray-900 py-3.5 px-7 text-center align-middle text-sm font-bold text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:scale-95 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            target="_blank" download>
                            Download Tugasmu
                        </a>
                    </div>
                    @endif
                    @else
                    @if (!$task->users->contains(auth()->id()))
                    <div class="bg-red-100 border border-red-200 text-sm text-red-800 rounded-lg p-4 mx-6 mb-4"
                        role="alert">
                        <span class="font-bold">Anda belum mengumpulkan tugas.</span> Jika ada kendala, hubungi
                        dosen
                        pengampu yang bersangkutan.
                    </div>
                    @else
                    <div class="p-6 pt-3">
                        <a href="{{ asset('storage/' . $task->users()->where('user_id', auth()->id())->first()->pivot->file_path) }}"
                            class="block w-full select-none rounded-lg bg-gray-900 py-3.5 px-7 text-center align-middle text-sm font-bold text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:scale-95 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            target="_blank" download>
                            Download Tugasmu
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <img src="{{ asset('images/task.svg') }}" alt="Empty" class="w-1/3 mx-auto">
        <p class="text-xl font-medium text-slate-500 -mt-4 text-center">Tidak ada tugas.</p>
        @endif
    </section>
</main>
@endsection