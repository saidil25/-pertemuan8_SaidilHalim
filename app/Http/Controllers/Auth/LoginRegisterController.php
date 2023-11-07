<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
        $this->middleware('guest')->except(['logout', 'dashboard']);
        $this->middleware('auth')->only('dashboard');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max: 250 |unique:users',
            'password' => 'required|min:8|confirmed',
            'photo' => 'image|nullable|max:1999'
        ]);

        $path = null;
        $thumbnailPath = null;
        
        if ($request->hasFile('photo')) {
            $filenameWithExt = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('photo')->storeAs('photos', $filenameSimpan, 'public');
        
            // Buat thumbnail
            $thumbnail = Image::make($request->file('photo'));
            $thumbnail->resize(150, 150); // Ganti ukuran sesuai kebutuhan
            $thumbnailFilename = $filename . '_thumbnail_' . time() . '.' . $extension;
            $thumbnailPath = 'photos/' . $thumbnailFilename;
        
            // Simpan thumbnail
            Storage::put($thumbnailPath, $thumbnail->stream());
        }
        

        
        else {
            // Tidak ada file yang diupload
        }
        

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $path,
            'thumbnail' => $thumbnailPath, // Tambahkan path thumbnail ke sini
        ]);
        
           
         $credentials = $request->only('email', 'password');
            Auth::attempt ($credentials);
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess ('You have successfully registered & loggedin!');
            
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate
        ([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt ($credentials)) {
            $request->session()->regenerate() ;
            return redirect ()->route('dashboard')
            ->withSuccess ('You have successfully logged in!');
            }

        return back()->withErrors ([
            'email' => 'Your provided credentials do not match in our records.'
            ])->onlyInput ('email');
    }

    public function dashboard()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            return view('auth.dashboard', compact('user'));
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }
        
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login')
        ->withSuccess('You have logged out successfully!');
}



}
