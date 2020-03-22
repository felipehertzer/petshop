<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Pet;

class PetController extends Controller
{
    /**
     * Show list of pet
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = Pet::paginate(15);
        return response()->view('web.pet.index', compact('pets'));
    }
}
