@extends('layouts.app')

@section('title', 'Dosen | Dashboard')

@section('content')
<main class="bg-white bg-clip-padding bg-opacity-60 z-50 my-8" style="backdrop-filter: blur(40px)">
    <!-- task section -->
    <section>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Daftar Tugas</h1>
            <button type="button" id="addModalBtn"
                class="bg-sky-600 p-2 rounded border border-sky-700 hover:bg-sky-700 font-bold text-white text-sm">
                Tambah Tugas
            </button>
        </div>
        <div class="mt-5 flex flex-col gap-4 {{ count($tasks) > 0 ? '' : 'items-center' }}">
            @if (count($tasks) > 0)
            @foreach ($tasks as $index => $task)
            <div class="text-slate-800 space-y-2 p-4 bg-gray-50 hover:bg-gray-100 border border-gray-100 rounded-md">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h1 class="text-xl font-bold">{{ $task->title }}</h1>
                        <div class="flex items-center gap-4">
                            <div class="flex gap-2 items-center">
                                <ion-icon name="golf-outline" class="w-4 h-4"></ion-icon>
                                <span class="text-sm">Status : </span>
                                @if ($task->status == 'active')
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-[2px] px-3 rounded-lg text-[10px] font-medium bg-green-100 text-green-800 border border-green-300">Aktif</span>
                                @else
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-[2px] px-3 rounded-lg text-[10px] font-medium bg-red-100 text-red-800 border border-red-300">Tidak
                                    Aktif</span>
                                @endif
                            </div>
                            <div class="flex gap-2 items-center">
                                <ion-icon name="people-outline"></ion-icon>
                                <div class="text-sm">Mahasiswa :
                                    {{$task->users->count()}}/{{$students->count()}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mr-3 accordionWrapper">
                        <div class="group relative cursor-pointer">
                            <ion-icon name="ellipsis-vertical-circle" class="w-6 h-6"></ion-icon>
                            <div
                                class="absolute hidden group-hover:block right-0 z-50 top-7 w-32 origin-top-right rounded-md bg-white shadow-lg border border-gray-200 focus:outline-none">
                                <div class="py-1">
                                    <button type="submit" id="editBtn"
                                        class="btn-edit-task flex items-center gap-2 text-gray-700 hover:text-green-700 hover:bg-green-50 w-full px-4 py-2 mt-1 text-left text-sm"
                                        role="menuitem" tabindex="-1" data-task-id="{{ $task->id }}"> <ion-icon
                                            name="create-outline"></ion-icon>
                                        <p>Edit</p>
                                    </button>
                                    <button type="submit" id="deleteBtn"
                                        class="btn-delete-task flex items-center gap-2 text-gray-700 hover:text-red-700 hover:bg-red-50 w-full px-4 py-2 mt-1 text-left text-sm"
                                        role="menuitem" tabindex="-1" data-task-id="{{ $task->id }}">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        <p>Hapus</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="accordion{{ $index + 1 }}" class="">
                            <ion-icon name="add-circle-outline" class="w-6 h-6" id="accordionPlusIcon{{ $index + 1 }}">
                            </ion-icon>
                            <ion-icon name="remove-circle-outline" class="hidden w-6 h-6"
                                id="accordionMinusIcon{{ $index + 1 }}"></ion-icon>
                        </button>
                    </div>
                </div>

                <div id="accordionElement{{ $index + 1 }}" class="hidden !mt-7">
                    <p class="font-semibold text-sm">Deskripsi :</p>
                    <p class="leading-7 text-sm">
                        {{ $task->description }}
                    </p>
                    @if ($task->file)
                    <div class="flex flex-wrap mt-2">
                        <a href="{{ asset('storage/' . $task->file) }}"
                            class="download-button transform active:scale-95 bg-lime-600 hover:bg-lime-700 text-white px-4 py-3 rounded-[4px] font-semibold"
                            target="_blank" download>
                            <div class="flex justify-center items-center relative">
                                <div class="svg-container">
                                    <!-- Download Icon -->
                                    <svg class="download-icon" width="12" height="16" viewBox="0 0 18 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path class="download-arrow" d="M13 9L9 13M9 13L5 9M9 13V1" stroke="#F2F2F2"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M1 17V18C1 18.7956 1.31607 19.5587 1.87868 20.1213C2.44129 20.6839 3.20435 21 4 21H14C14.7956 21 15.5587 20.6839 16.1213 20.1213C16.6839 19.5587 17 18.7956 17 18V17"
                                            stroke="#F2F2F2" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="pl-2 !leading-none text-sm">Download Lampiran</div>
                            </div>
                        </a>
                    </div>
                    @endif
                    <div class="!mt-7">
                        <p class="font-semibold text-base">
                            Daftar Mahasiswa yang Mengumpulkan Tugas
                        </p>
                        @if ($task->users->count() > 0)
                        <div class="mt-5">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table
                                    class="w-full text-sm text-left rtl:text-right text-gray-500 border border-gray-200">
                                    <thead class="text-xs text-gray-700 uppercase bg-green-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                Nama Mahasiswa
                                            </th>
                                            <th scope="col" class="px-6 py-3">NIM</th>
                                            <th scope="col" class="px-6 py-3">File</th>
                                            <th scope="col" class="px-6 py-3">Nilai
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($task->users as $student)
                                        <tr class="bg-white hover:bg-gray-50">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $student->name }}
                                            </th>
                                            <td class="px-6 py-4">{{ $student->nim }}</td>
                                            <td class="px-6 py-4">
                                                @if($student->pivot->file_path)
                                                <a href="{{ asset('storage/' . $student->pivot->file_path) }}"
                                                    class="py-1 px-3 text-xs bg-sky-600 border border-sky-700 hover:bg-sky-800 rounded text-white font-bold"
                                                    target="_blank" download>
                                                    <span>Download</span>
                                                    <ion-icon name="download-outline"></ion-icon>
                                                </a>
                                                @else
                                                File belum diunggah
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($student->pivot->nilai !== null)
                                                <form
                                                    action="{{ route('edit.grade', ['taskId' => $task->id, 'userId' => $student->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="nilai" min="0" max="100"
                                                        value="{{ $student->pivot->nilai }}"
                                                        class="border border-slate-700 rounded-sm text-slate-800 w-14 h-6 text-center font-semibold"
                                                        required>
                                                    <button type="submit">Edit</button>
                                                </form>
                                                @else
                                                <form
                                                    action="{{ route('submit.grade', ['taskId' => $task->id, 'userId' => $student->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="number" name="nilai" min="0" max="100"
                                                        class="border w-14 h-6 border-slate-700 rounded-sm text-slate-800 text-center font-semibold"
                                                        required>
                                                    <button type="submit">Submit Nilai</button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @else
                        <img src="{{ asset('images/student-task.svg') }}" alt="Empty" class="w-1/3 mx-auto">
                        <p class="text-base font-medium text-slate-500 text-center">Belum ada mahasiswa
                            yang
                            mengumpulkan</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <img src="{{ asset('images/task.svg') }}" alt="Empty" class="w-1/3 mx-auto">
            <p class="text-xl font-medium text-slate-500 -mt-4">Tidak ada tugas.</p>
            @endif
        </div>
    </section>

    <!-- Students Section -->
    <section class="mt-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Daftar Mahasiswa</h1>
            <button type="button" id="addStudentBtn"
                class="bg-sky-600 p-2 rounded border border-sky-700 hover:bg-sky-700 font-bold text-white text-sm">
                Tambah Mahasiswa
            </button>
        </div>
        <div class="mt-5 {{ $students->count() > 0 ? '' : 'flex flex-col items-center' }}">
            @if($students->count() > 0)
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 border border-gray-200">
                    <thead class="text-xs text-gray-700 uppercase bg-green-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Rata-Rata</th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $student->name }}
                            </th>
                            <td class="px-6 py-4">{{ $student->nim }}</td>
                            <td class="px-6 py-4 md:truncate md:break-all">{{ $student->email }}</td>
                            <td class="px-6 py-4 font-semibold text-lg">
                                @if(number_format($student->averageScore,
                                0)>=80)
                                <p class="text-green-600">{{ number_format($student->averageScore, 0) }}</p>
                                @elseif(number_format($student->averageScore, 0)>=55)
                                <p class="text-yellow-600">{{ number_format($student->averageScore, 0) }}</p>
                                @else
                                <p class="text-red-600">{{ number_format($student->averageScore, 0) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" data-user-id="{{ $student->id }}"
                                    class="userDeleteButton p-2 rounded flex items-center text-red-700 bg-red-100 border border-red-700"
                                    title="Hapus">
                                    <ion-icon name="trash-outline" class="leading-none"></ion-icon>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <img src="{{ asset('images/students.svg') }}" alt="Empty" class="w-1/3 mx-auto">
            <p class="text-xl font-medium text-slate-500">Tidak ada mahasiswa.</p>
            @endif
        </div>
    </section>
</main>
@endsection
@section('modal')
<div id="addModal" tabindex="-1" aria-hidden="true"
    class="fixed hidden top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full backdrop-blur-sm animate__animated"
    style="
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
      ">
    <div class="relative w-full max-w-xl max-h-full mx-auto">
        <!-- Modal content -->
        <div
            class="modalAddContent relative bg-white rounded-lg shadow animate__animated animate__fadeInDown animate__fast">
            <!-- Modal header -->
            <div class="flex items-start justify-between px-1 border-b rounded-t">
                <div class="w-full h-full ml-5 py-3 text-lg font-bold text-slate-900">
                    Tambah Tugas
                </div>
            </div>
            <!-- Modal body -->
            <form action="{{ route('dosen.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div
                    class="h-96 p-6 space-y-3 scrollbar scrollbar-w-3 scrollbar-thumb-zinc-400 scrollbar-track-gray-100 overflow-y-auto scrollbar-thumb-rounded-full">
                    <label for="input-judul" class="block text-sm font-medium mb-2">Judul</label>
                    <input type="text" id="input-judul" name="title"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Tugas 1" />
                    <label for="textarea-deskripsi" class="block text-sm font-medium mb-2 mt-4">Deskripsi</label>
                    <textarea id="textarea-deskripsi" name="description"
                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        rows="3" placeholder="Tugas ini merupakan ..."></textarea>
                    <label for="hs-select-label" class="block text-sm font-medium mb-2 mt-4">Status</label>
                    <select id="hs-select-label" name="status"
                        class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option selected disabled>Pilih Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    <div class="text-sm font-medium mb-2 mt-4">Pilih File</div>
                    <label for="small-file-input" class="sr-only">Choose file</label>
                    <input type="file" name="file" id="small-file-input"
                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0 file:me-4 file:py-2 file:px-4" />
                </div>
                <div class="flex items-center gap-3 justify-end p-3 border-t border-gray-200 rounded-b">
                    <button type="button" id="closeButton" class="text-white self-end bg-red-600 hover:bg-red-700 focus:outline-none font-medium rounded-lg
                                text-sm px-5 py-2.5 text-center">
                        Batal
                    </button>
                    <button
                        class="text-white self-end bg-sky-700 hover:bg-sky-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="editModal" tabindex="-1" aria-hidden="true"
    class="fixed hidden top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full backdrop-blur-sm"
    style="
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
          ">
    <div class="relative w-full max-w-xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow animate__animated animate__fadeInDown animate__fast">
            <!-- Modal header -->
            <div class="flex items-start justify-between px-1 border-b rounded-t">
                <div class="w-full h-full ml-5 py-3 text-lg font-bold text-slate-900">
                    Edit Tugas
                </div>
            </div>
            @if ($tasks->count() > 0)
            <!-- Modal body -->
            <form id="editTaskForm" action="{{ route('dosen.update', $task->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div
                    class="h-96 p-6 space-y-3 scrollbar scrollbar-w-3 scrollbar-thumb-zinc-400 scrollbar-track-gray-100 overflow-y-auto scrollbar-thumb-rounded-full">
                    <label for="input-judul" class="block text-sm font-medium mb-2">Judul</label>
                    <input type="text" id="editTitle" name="title"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Tugas 1" value="{{ $task->title }}" />
                    <label for="textarea-deskripsi" class="block text-sm font-medium mb-2 mt-4">Deskripsi</label>
                    <textarea id="editDescription" name="description"
                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        rows="3" placeholder="Tugas ini merupakan ..."> {{ $task->description }}</textarea>
                    <label for="hs-select-label" class="block text-sm font-medium mb-2 mt-4">Status</label>
                    <select id="editStatus" name="status"
                        class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option value="active" @if ($task && $task->status == 'active') selected @endif>Aktif
                        </option>
                        <option value="inactive" @if ($task && $task->status == 'inactive') selected @endif>Tidak
                            Aktif</option>
                    </select>
                    <div class="text-sm font-medium mb-2 mt-4">Pilih File</div>
                    <label for="small-edit-file-input" class="sr-only">Choose file</label>
                    <input type="file" name="file" id="small-edit-file-input"
                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none file:bg-gray-50 file:border-0file:me-4 file:py-2 file:px-4" />
                </div>
                <div class="flex items-center gap-3 justify-end p-3 border-t border-gray-200 rounded-b">
                    <button type="button" id="closeEditButton" class="text-white self-end bg-red-600 hover:bg-red-700 focus:outline-none font-medium rounded-lg
                                                        text-sm px-5 py-2.5 text-center">
                        Batal
                    </button>
                    <button
                        class="text-white self-end bg-sky-700 hover:bg-sky-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Edit
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
<div id="addStudentModal" tabindex="-1" aria-hidden="true"
    class="fixed hidden top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full backdrop-blur-sm"
    style="
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
          ">
    <div class="relative w-full max-w-xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow animate__animated animate__fadeInDown animate__fast">
            <!-- Modal header -->
            <div class="flex items-start justify-between px-1 border-b rounded-t">
                <div class="w-full h-full ml-5 py-3 text-lg font-bold text-slate-900">
                    Tambah Mahasiswa
                </div>
            </div>
            <!-- Modal body -->
            <form action="{{ route('register') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div
                    class="h-96 p-6 space-y-3 scrollbar scrollbar-w-3 scrollbar-thumb-zinc-400 scrollbar-track-gray-100 overflow-y-auto scrollbar-thumb-rounded-full">
                    <label for="input-nama" class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" id="input-nama" name="name"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="Dinar Laksmana" />
                    <label for="hs-select-gender-label" class="block text-sm font-medium mb-2 mt-4">Jenis
                        Kelamin</label>
                    <select id="hs-select-gender-label" name="gender"
                        class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <option selected disabled>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <label for="input-nim" class="block text-sm font-medium mb-2 mt-4">NIM</label>
                    <input type="number" id="input-nim" name="nim"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="202110370311900" />
                    <label for="input-email" class="block text-sm font-medium mb-2 mt-4">Email</label>
                    <input type="email" id="input-email" name="email"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="example@webmail.umm.ac.id" />
                    <label for="input-password" class="block text-sm font-medium mb-2 mt-4">Password</label>
                    <input type="password" id="input-password" name="password"
                        class="py-3 px-4 block w-full border border-gray-400 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        placeholder="*******" />
                </div>
                <div class="flex items-center gap-3 justify-end p-3 border-t border-gray-200 rounded-b">
                    <button type="button" id="closeStudentButton" class="text-white self-end bg-red-600 hover:bg-red-700 focus:outline-none font-medium rounded-lg
                                    text-sm px-5 py-2.5 text-center">
                        Batal
                    </button>
                    <button type="submit"
                        class="text-white self-end bg-sky-700 hover:bg-sky-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="deleteTaskModal" class="relative z-[999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 backdrop-blur-sm" style="background: linear-gradient(rgba(0, 0,
                            0, 0.5),
                            rgba(0, 0, 0, 0.5))"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate__animated animate__fadeInDown animate__fast">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Konfirmasi
                                Hapus</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah kamu yakin ingin menghapus tugas ini?. Jika
                                    yakin, tekan tombol hapus dibawah ini</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form id="deleteTaskForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Hapus</button>
                    </form>
                    <button type="button" id="closeDeleteButton"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="deleteUserModal" class="relative z-[999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 backdrop-blur-sm" style="background: linear-gradient(rgba(0, 0,
                            0, 0.5),
                            rgba(0, 0, 0, 0.5))"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg animate__animated animate__fadeInDown animate__fast">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Konfirmasi
                                Hapus</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Apakah kamu yakin ingin menghapus pengguna ini?.
                                    Jika
                                    yakin, tekan tombol hapus dibawah ini</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <form id="deleteUserForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user_id" id="user_id">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Hapus</button>
                    </form>
                    <button type="button" id="closeDeleteUserButton"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const userDeleteButton = document.querySelectorAll(".userDeleteButton");
    const accordionWrappers = document.querySelectorAll(".accordionWrapper");
    const addModalBtn = document.querySelector("#addModalBtn");
    const addStudentBtn = document.querySelector("#addStudentBtn");
    const closeButton = document.querySelector("#closeButton");
    const closeStudentButton = document.querySelector("#closeStudentButton");
    const closeEditButton = document.querySelector("#closeEditButton");
    const closeDeleteUserButton = document.querySelector("#closeDeleteUserButton");
    const addModal = document.querySelector("#addModal");
    const editModal = document.querySelector("#editModal");
    const addStudentModal = document.querySelector("#addStudentModal");
    const deleteUserModal = document.querySelector("#deleteUserModal");
    const editBtns = document.querySelectorAll("#editBtn");
    const userIdInput = document.getElementById('user_id');

    const editButton = document.querySelectorAll(".btn-edit-task");

    var tasks = @json($tasks);

    const deleteButtons = document.querySelectorAll(".btn-delete-task");
    const deleteModal = document.getElementById('deleteTaskModal');
    const closeDeleteButton = document.getElementById('closeDeleteButton');
    const deleteForm = document.getElementById('deleteTaskForm');

    addStudentBtn?.addEventListener("click", () => {
        addStudentModal.classList.remove("hidden");
    })

    closeStudentButton?.addEventListener("click", () => {
        addStudentModal.classList.add("hidden");
    })

    closeDeleteUserButton?.addEventListener("click", () => {
        deleteUserModal.classList.add("hidden");
    })

    userDeleteButton?.forEach(btn => {
        btn.addEventListener("click", () => {
            const userId = btn.dataset.userId;
            deleteUserForm.action = `/delete/student/${userId}`;
            deleteUserModal.classList.remove("hidden");
        })
    });

    deleteButtons?.forEach((btn) => {
        btn.addEventListener("click", () => {
            const taskId = btn.dataset.taskId;
            deleteForm.action = `/dosen/${taskId}`;
            deleteModal.classList.remove("hidden");
        })
    })

    closeDeleteButton?.addEventListener("click", () => {
        deleteModal.classList.add("hidden");
    })

    editButton?.forEach((btn) => {
        btn.addEventListener("click", () => {
            const taskId = btn.dataset.taskId;

            const task = tasks.find(task => task.id === parseInt(taskId));

            const editForm = document.getElementById('editTaskForm');
            editForm.action = `/dosen/${taskId}`;

            document.getElementById('editTitle').value = task.title;
            document.getElementById('editDescription').value = task.description;
            document.getElementById('editStatus').value = task.status;

            editModal.classList.remove("hidden");
        })
    })

    closeEditButton?.addEventListener("click", () => {
        editModal.classList.add("hidden");
    })

    addModalBtn?.addEventListener("click", () => {
        addModal.classList.remove("hidden");
    });

    closeButton?.addEventListener("click", () => {
        addModal.classList.add("hidden");
    })

    accordionWrappers?.forEach((wrapper, index) => {
        const accordion = document.querySelector(`#accordion${index + 1}`);
        const accordionPlusIcon = document.querySelector(
            `#accordionPlusIcon${index + 1}`
        );
        const accordionMinusIcon = document.querySelector(
            `#accordionMinusIcon${index + 1}`
        );
        const accordionElement = document.querySelector(
            `#accordionElement${index + 1}`
        );

        accordion?.addEventListener("click", () => {
            accordionElement.classList.toggle("hidden");
            accordionPlusIcon.classList.toggle("hidden");
            accordionMinusIcon.classList.toggle("hidden");
        });
    });
</script>
@endpush