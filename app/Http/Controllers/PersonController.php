<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::all();
        
        return Inertia::render('People/Index',[   //Crea la ruta para que cuando en web.php llame a esta funcion para crear la ruta, tome el archivo Index.vue
            'People' => $people
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
            'People/Create'
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
            'ci' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',

        ]);
        Person::create([
            'id' => $request->id,
            'ci' => $request->ci,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email
        ]);
        sleep(1);

        return redirect()->route('dashboard')->with('message', 'Person Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        return Inertia::render(
            'People/Edit',
            [
                'person' => $person
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'ci' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $person->ci = $request->ci;
        $person->name =  $request->name;
        $person->last_name = $request->last_name;
        $person->phone_number = $request->phone_number;
        $person->address = $request->address;
        $person->email = $request->email;
        $person->save();
        sleep(1);

        return redirect()->route('people.index')->with('message', 'People Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
        sleep(1);

        return redirect()->route('people.index')->with('message', 'Person Delete Successfully');
    }
}
