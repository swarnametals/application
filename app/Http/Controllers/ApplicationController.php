<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Certificate;
use Illuminate\Http\Request;

class ApplicationController extends Controller {
    public function create() {
        return view('applications.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:20',
            'nrc_number' => 'required|string|max:20',
            'position_applied_for' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'certificates' => 'nullable|array',
            'certificates.*' => 'file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            $application = Application::create(
                $request->except(['certificates', 'resume_path', 'cover_letter_path'])
            );

            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
                $application->resume_path = $resumePath;
            }

            if ($request->hasFile('cover_letter')) {
                $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
                $application->cover_letter_path = $coverLetterPath;
            }

            if ($request->has('certificates')) {
                foreach ($request->file('certificates') as $file) {
                    $certificatePath = $file->store('certificates', 'public');
                    Certificate::create([
                        'application_id' => $application->id,
                        'file_path' => $certificatePath,
                    ]);
                }
            }

            $application->save();

            return redirect()->route('applications.create')->with('success', 'Application submitted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'There was an error processing your application. Please try again.'])->withInput();
        }
    }

    public function getApplicationTrackingForm() {
        return view('applications.track');
    }

    public function trackApplication(Request $request) {
        $request->validate([
            'nrc_number' => 'required|string|max:20',
        ]);

        $application = Application::where('nrc_number', $request->nrc_number)->first();

        if (!$application) {
            return back()->withErrors(['nrc_number' => 'No application found with this NRC number.']);
        }

        return view('applications.track-status', ['application' => $application]);
    }


    public function show($id) {
        $application = Application::with('certificates')->findOrFail($id);

        return view('applications.show', compact('application'));
    }

    public function index(Request $request) {
        $query = Application::with('certificates');

        if ($request->years_of_experience) {
            $query->where('years_of_experience', $request->input('years_of_experience'));
        }

        if ($request->position_applied_for) {
            $query->where('position_applied_for', $request->input('position_applied_for'));
        }

        $applications = $query->orderBy('created_at', 'desc')->get();

        return view('applications.index', compact('applications'));
    }

    public function uploadCertificates(Request $request, Application $application) {
        $request->validate([
            'certificates.*' => 'required|file',
        ]);

        foreach ($request->file('certificates') as $file) {
            $path = $file->store('certificates');
            Certificate::create([
                'application_id' => $application->id,
                'file_path' => $path,
            ]);
        }

        return redirect()->route('applications.index')->with('success', 'Certificates uploaded successfully.');
    }
}
