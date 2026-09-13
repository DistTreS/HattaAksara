<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, Tim Redaksi Hatta Aksara.');
            }

            if ($user->isHattaMuda()) {
                if ($user->status === 'pending') {
                    return redirect()->route('alumni.pending-notice');
                }

                if ($user->status === 'rejected') {
                    Auth::logout();

                    return redirect()->route('login')->with('error', 'Mohon maaf, permohonan akun alumni Anda belum dapat disetujui.');
                }

                return redirect()->intended(route('alumni.dashboard'))->with('success', 'Selamat datang di Ruang Hatta Muda Connection, '.$user->name.'!');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Anda telah berhasil keluar.');
    }

    public function showRegisterHattaMuda(): View
    {
        return view('auth.register-hatta-muda');
    }

    public function registerHattaMuda(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'islt_batch' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'school_origin' => ['required', 'string', 'max:255'],
            'current_institution' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'proof_document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_document')) {
            $proofPath = $request->file('proof_document')->store('proofs', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'hatta_muda',
            'status' => 'pending',
        ]);

        AlumniProfile::create([
            'user_id' => $user->id,
            'islt_batch' => $validated['islt_batch'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'school_origin' => $validated['school_origin'],
            'current_institution' => $validated['current_institution'] ?? null,
            'phone_number' => $validated['phone_number'],
            'is_phone_public' => $request->boolean('is_phone_public'),
            'bio' => $validated['bio'] ?? null,
            'proof_document_path' => $proofPath,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
        ]);

        Auth::login($user);

        return redirect()->route('alumni.pending-notice')->with('success', 'Pendaftaran alumni berhasil dikirimkan! Akun Anda sedang menunggu verifikasi admin.');
    }

    public function pendingNotice(): View
    {
        return view('auth.pending-notice');
    }
}
