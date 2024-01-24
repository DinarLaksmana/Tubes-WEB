<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $students = User::where('type', 0)->get();
        $tasks = Task::with('users')->get();

        foreach ($students as $student) {
            // Mengambil nilai dari setiap tugas untuk mahasiswa tertentu
            $taskIds = $tasks->pluck('id')->toArray();

            // Mengambil nilai-nilai yang sudah di-submit oleh mahasiswa
            $submittedTasks = DB::table('task_user')
                ->where('user_id', $student->id)
                ->whereIn('task_id', $taskIds)
                ->pluck('nilai')
                ->toArray();

            // Menambahkan nilai null untuk tugas yang tidak di-submit
            $missingTasks = array_diff($taskIds, DB::table('task_user')
                ->where('user_id', $student->id)
                ->pluck('task_id')
                ->toArray());

            foreach ($missingTasks as $missingTask) {
                array_push($submittedTasks, null);
            }

            // Menghitung jumlah nilai yang sudah di-submit dan rata-ratanya
            $submittedCount = count($submittedTasks);
            $submittedTotal = array_sum($submittedTasks);
            $averageScore = $submittedCount > 0 ? $submittedTotal / $submittedCount : 0;

            // Menambahkan rata-rata nilai ke dalam object mahasiswa
            $student->averageScore = $averageScore;
        }

        return view('dosen.index', compact('students', 'tasks'));
    }

    public function create()
    {
        return view('dosen.index');
    }

    public function store(Request $request)
    {
        // Validasi input, termasuk file yang diunggah
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'file' => 'file', // Tentukan bahwa file tidak wajib diunggah
        ]);

        // Inisialisasi variabel filePath
        $filePath = null;

        // Cek apakah file diunggah
        if ($request->hasFile('file')) {
            // Menyimpan file yang diunggah ke dalam folder public/storage/task_files
            $file = $request->file('file');
            $filePath = $file->store('task_files', 'public');
        }

        // Menyimpan data tugas beserta path file ke dalam database
        $task = new Task();
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->status = $validatedData['status'];
        $task->file = $filePath; // Simpan path file ke dalam kolom file_path
        $task->save();

        return redirect('/dosen')->with('success', 'Tugas baru ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('task_files', 'public');
        } else {
            $filePath = $task->file;
        }

        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->status = $validatedData['status'];
        $task->file = $filePath;
        $task->save();

        return redirect('/dosen')->with('success', 'Tugas diperbarui');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect('/dosen')->with('success', 'Tugas dihapus');
    }

    public function submitGrade($taskId, $userId, Request $request)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        $nilai = $request->input('nilai');

        // Simpan nilai pada pivot table
        $task->users()->updateExistingPivot($user->id, ['nilai' => $nilai]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }

    public function editGrade($taskId, $userId, Request $request)
    {
        $task = Task::findOrFail($taskId);
        $user = User::findOrFail($userId);

        $nilai = $request->input('nilai');

        // Update nilai pada pivot table
        $task->users()->updateExistingPivot($user->id, ['nilai' => $nilai]);

        return redirect()->back()->with('success', 'Nilai berhasil diubah');
    }
}
