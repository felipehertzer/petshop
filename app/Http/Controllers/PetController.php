<?php


namespace App\Http\Controllers;


use App\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function create(Request $request){
        $pet = new Pet();

        $pet->save();
    }

    public function update(Request $request){

    }

    public function findByTags(Request $request){

    }

    public function updateByForm(Request $request, $petId){

    }

    public function findById($petId){
        $pet = Pet::findOrFail($petId);

        $pet->save();
    }

    public function remove($petId){
        $pet = Pet::findOrFail($petId);
        $pet->delete();
    }

    public function uploadImage(Request $request, $petId){
        $pet = Pet::findOrFail($petId);
    }
}
