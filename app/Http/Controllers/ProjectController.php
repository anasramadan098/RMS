<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get The Project For The Authenticated User
        $project = Project::first();
        return view('projects.index', [
            'project' => $project,
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', [
            'project' => $project,
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $project->update($request->all());


        if ($request->link) {
            $project->link = $request->link;

            // Generate QR code for the bill
            $qrCodeSvg = QrCode::format('svg')->size(200)->generate($project->link);

            // Save The QR CODE In Public Path
            $qrCodePath = public_path("qrcodes/$project->id _ $project->name.svg");

            // Create the directory if it doesn't exist
            if (!file_exists(public_path('qrcodes'))) {
                mkdir(public_path('qrcodes'), 0755, true);
            }
            // Always write the SVG to ensure it's not empty or 0kb
            file_put_contents($qrCodePath, $qrCodeSvg);


            // Get The path
            $project->qr_code = asset("qrcodes/$project->id _ $project->name.svg");
        }

        
        $project->save();            

        return redirect()->route('projects.index')->with('msg', __('projects.project_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
