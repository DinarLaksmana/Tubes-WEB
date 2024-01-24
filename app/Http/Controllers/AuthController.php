<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register()
    {
        return view('dosen.index');
    }

    public function registerPost(Request $request)
    {
        $user = new User();

        $user->name = request('name');
        $user->nim = request('nim');
        $user->email = request('email');
        $user->password = Hash::make($request->password);
        $user->gender = request('gender');
        $user->save();

        return back()->with('success', 'Register Pengguna Berhasil');
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (auth()->user()->type == 'dosen') {
                return redirect()->route('dosen.index')->with('success', 'Halo ' . auth()->user()->name);
            } elseif (auth()->user()->type == 'mahasiswa') {
                return redirect()->route('mahasiswa.index')->with('success', 'Halo ' . auth()->user()->name);
            }
        } else {
            return redirect()->route('login')->with('error', 'Email dan Password salah.');
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }

    public function deleteStudent($studentId)
    {
        $student = User::findOrFail($studentId);
        // Lakukan proses penghapusan mahasiswa di sini

        // Contoh penghapusan
        $student->delete();

        return redirect('/dosen')->with('success', 'Pengguna berhasil dihapus');
    }
}
