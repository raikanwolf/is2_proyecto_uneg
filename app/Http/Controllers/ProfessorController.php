<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professors = Professor::all();
        
        return Inertia::render('Professors/Index',[   //Crea la ruta para que cuando en web.php llame a esta funcion para crear la ruta, tome el archivo Index.vue
            'Professors' => $professors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render(
            'Professors/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|',
            'profession' => 'required|string|max:255',
            'date_admission' => 'required|date|max:255',
            'professor_type' => 'required|string|max:255',

        ]);
        Professor::create([
            'id' => $request->id,
            'profession' => $request->profession,
            'date_admission' => $request->date_admission,
            'professor_type' => $request->professor_type
        ]);
        sleep(1);

        return redirect()->route('dashboard')->with('message', 'Professor Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show(Professor $Professor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit(Professor $Professor)
    {
        return Inertia::render(
            'Professors/Edit',
            [
                'professor' => $professor
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professor $Professor)
    {
        $request->validate([
            'id' => 'required|integer|',
            'profession' => 'required|string|max:255',
            'date_admission' => 'required|date|max:255',
            'professor_type' => 'required|string|max:255',
        ]);

        $professor->id = $request->id;
        $professor->profession =  $request->profession;
        $professor->date_admission = $request->date_admission;
        $professor->professor_type = $request->professor_type;
        $professor->save();
        sleep(1);

        return redirect()->route('professors.index')->with('message', 'Professors Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professor $professor)
    {
        $professor->delete();
        sleep(1);

        return redirect()->route('professors.index')->with('message', 'Professor Delete Successfully');
    }
}
