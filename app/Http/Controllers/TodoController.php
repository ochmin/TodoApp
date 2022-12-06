<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('register');
    }

    public function login()
    {
        //menampilkan halaman awal atau menampilkan banyak data
        return view('login');
    }

    public function registerAccount(Request $request)
    {
        // dd($request->all());
        // validasi input
        $request->validate([
            'email' => 'required|email:dns',
            'username' => 'required|min:4|max:8',
            'password' => 'required|min:4',
            'name' => 'required|min:3',
        ]);
        // input data ke db
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // redirect kemana setelah berhasil tambah data + dikirim pemberitahuan
        return redirect('/')->with('success', 'Berhasil menambahkan akun! silahkan login');
    }

    public function auth(Request $request)
    {
        // array ke2 sbgai custom msg
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists' => 'username ini belum tersedia',
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',
        ]);

        $user = $request->only('username', 'password');
        // authentication
        if (Auth::attempt($user)) {
            return redirect()->route('dashboard');
        }else {
            return redirect()->back()->with('error', 'Gagal login, silahkan cek dan coba lagi!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //menampilkan halaman input form tambah data
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi form
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8',
        ]);
        // kirim data ke database yg table todos : model Todo
        // yg ' ' = nama column
        // yg $request-> = value name di input
        // kenapa kirim 5 data pdhl di input ada 3 inputan? kalau dicek di table todos itu kan ada 6 column yg harus diisi, salah satunya column done_date yg nullable, kalau nullable itu gausa diisi gpp jd ga diisi dulu
        // user_id ngambil id dari fitur auth (history login), supaya tau itu todo punya siapa
        // column status kan boolean, jd klo status si todo blm dikerjain = 0
        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);
        // kalau berhasil tambah ke db, bakal diarahin ke halaman dashboard dengan menampilkan pemberitahuan
        return redirect('/dashboard')->with('addTodo', 'Berhasil menambahkan data Todo!');
    }

    public function data()
    {
        // ambil data dari table todos
        $todos = Todo::all();
        // compact untuk mengirim data ke bladenya
        // isi di compact hrs sama kaya nama variablenya
        return view('data', compact('todos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //menampilkan satu data spesifik
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
       $todo = Todo::where('id', $id)->first();
       return view('edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8',
        ]);

        Todo::where('id', $id)->update([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);

        return redirect('/data')->with('successUpdate', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Todo::where('id', $id)->delete();
        return redirect('/data')->with('successDelete', 'Berhasil menghapus data Todo');
    }

public function updateToComplated(Request $request, $id)
    {
        
        Todo::where('id', '=', $id)->update([
            'status' => 1, 
            'done_time' => \Carbon\Carbon::now(), 
        ]);

        return redirect()->back()->with('done', 'Todo telah selesai dikerjakan');
        }
}