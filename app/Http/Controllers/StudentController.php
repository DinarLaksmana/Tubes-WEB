<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $studentId = Auth::id();

        // Dapatkan tugas yang sudah dibuat oleh dosen
        $tasks = Task::all();

        // Dapatkan tugas yang sudah dikumpulkan oleh mahasiswa yang login
        $submittedTasks = DB::table('task_user')
            ->where('user_id', $studentId)
            ->get();

        // Inisialisasi variabel nilai dan jumlah tugas yang sudah dikumpulkan
        $totalScore = 0;
        $submittedTasksCount = 0;

        // Loop melalui tugas yang sudah dikumpulkan
        foreach ($submittedTasks as $submittedTask) {
            // Tugas yang dikumpulkan harus ada dalam daftar tugas yang dibuat oleh dosen
            $task = Task::find($submittedTask->task_id);

            if ($task) {
                // Jika nilai belum diisi, anggap nilai 0
                $nilai = $submittedTask->nilai ?? 0;

                // Tambahkan nilai ke total
                $totalScore += $nilai;

                // Tandai bahwa mahasiswa telah mengumpulkan tugas ini
                $submittedTasksCount++;
            }
        }

        // Dapatkan jumlah semua tugas yang sudah dibuat oleh dosen
        $totalTasks = count($tasks);

        // Jika mahasiswa telah mengumpulkan setidaknya satu tugas, hitung nilai rata-rata
        $averageScore = ($submittedTasksCount > 0 && $totalTasks > 0) ? ($totalScore / $totalTasks) : 0;

        return view("mahasiswa.index", compact("tasks", "averageScore"));
    }

    public function submitTask(Request $request, Task $task)
    {
        $user = auth()->user();

        // Periksa apakah status tugas masih aktif sebelum mengizinkan pengumpulan
        if ($task->status === 'active') {
            $request->validate([
                'task_file' => 'required|mimes:pdf,docx|max:2048', // Sesuaikan dengan jenis file yang diperbolehkan
            ]);

            $file = $request->file('task_file');
            $filePath = $file->store('task_files', 'public');

            $task->users()->attach($user->id, ['file_path' => $filePath]);

            return back()->with('success', 'Tugas berhasil diunggah');
        }

        return back()->with('error', 'Tugas sudah ditutup');
    }

}
