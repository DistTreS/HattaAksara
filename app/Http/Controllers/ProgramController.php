<?php

namespace App\Http\Controllers;

use App\Models\IsltApplicant;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::orderBy('sort_order')->get();

        return view('program.index', compact('programs'));
    }

    public function islt(): View
    {
        $program = Program::where('slug', 'islt')->firstOrFail();

        return view('program.islt', compact('program'));
    }

    public function showRegisterIslt(): View
    {
        $program = Program::where('slug', 'islt')->firstOrFail();

        return view('program.daftar-islt', compact('program'));
    }

    public function storeRegisterIslt(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'nisn' => ['nullable', 'string', 'max:30'],
            'birth_place' => ['required', 'string', 'max:100'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:L,P'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'province' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'school_name' => ['required', 'string', 'max:255'],
            'osis_position' => ['required', 'string', 'max:100'],
            'organization_experience' => ['required', 'string', 'max:2000'],
            'motivation_essay' => ['required', 'string', 'max:3000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'recommendation_letter' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('applicants/photos', 'public');
        }

        $letterPath = null;
        if ($request->hasFile('recommendation_letter')) {
            $letterPath = $request->file('recommendation_letter')->store('applicants/documents', 'public');
        }

        $registrationCode = IsltApplicant::generateRegistrationCode();

        $applicant = IsltApplicant::create([
            'registration_code' => $registrationCode,
            'full_name' => $validated['full_name'],
            'nisn' => $validated['nisn'] ?? null,
            'birth_place' => $validated['birth_place'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'whatsapp_number' => $validated['whatsapp_number'],
            'email' => $validated['email'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'school_name' => $validated['school_name'],
            'osis_position' => $validated['osis_position'],
            'organization_experience' => $validated['organization_experience'],
            'motivation_essay' => $validated['motivation_essay'],
            'photo_path' => $photoPath,
            'recommendation_letter_path' => $letterPath,
            'selection_status' => 'submitted',
        ]);

        return redirect()->route('program.islt.success', ['code' => $registrationCode])
            ->with('success', 'Pendaftaran Anda berhasil dikirimkan!');
    }

    public function registrationSuccess(string $code): View
    {
        $applicant = IsltApplicant::where('registration_code', $code)->firstOrFail();

        return view('program.pendaftaran-sukses', compact('applicant'));
    }

    public function mediaEdukasi(): View
    {
        $program = Program::where('slug', 'media-edukasi')->firstOrFail();

        return view('program.media-edukasi', compact('program'));
    }
}
