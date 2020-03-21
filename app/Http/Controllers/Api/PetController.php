<?php


namespace App\Http\Controllers\Api;


use App\Category;
use App\Http\Controllers\Controller;
use App\Pet;
use App\Photo;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    private function createOrUpdate(Request $request, $petId = null)
    {
        $categoryId = $request->get('category')['id'];
        if (!$categoryId) {
            $category = new Category();
            $category->name = $request->get('category')['name'];
            $category->save();

            $categoryId = $category->id;
        }

        if ($petId) {
            $pet = Pet::findOrFail($petId);
            $pet->tags()->delete();
            $pet->photos()->delete();
        } else {
            $pet = new Pet();
        }

        $pet->name = $request->get('name');
        $pet->status = $request->get('status');
        $pet->categoryId = $categoryId;
        $pet->save();

        foreach ($request->get('photoUrls') as $key => $photo) {
            $netPhoto = new Photo();
            $netPhoto->photoUrl = $photo;
            $netPhoto->petId = $pet->id;
            $netPhoto->save();
        }

        foreach ($request->get('tags') as $tag) {
            $netTag = new Tag();
            $netTag->name = strtolower($tag['name']);
            $netTag->petId = $pet->id;
            $netTag->save();
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'category.id' => 'required|numeric',
                'category.name' => 'required',
                'photoUrls' => 'required|array',
                'tags' => 'required|array',
                'status' => 'required|in:available,pending,sold',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 405);
        }

        DB::beginTransaction();

        self::createOrUpdate($request);

        DB::commit();

        return response()->json('', 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|numeric',
                'name' => 'required',
                'category.id' => 'required|numeric',
                'category.name' => 'required',
                'photoUrls' => 'required|array',
                'tags' => 'required|array',
                'status' => 'required|in:available,pending,sold',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 405);
        }

        DB::beginTransaction();

        self::createOrUpdate($request, $request->get('id'));

        DB::commit();

        return response()->json('', 200);
    }

    public function findByTags(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'tags' => 'required|array',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 405);
        }

        $pet = Pet::whereHas('tags', fn($q) => $q->whereIn('name', array_map('strtolower', $request->get('tags'))))
            ->with(['category', 'tags', 'photos'])->get();

        return response()->json($pet, 200);
    }

    public function updateByForm(Request $request, $petId)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'status' => 'required|in:available,pending,sold',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 405);
        }

        DB::beginTransaction();

        $pet = Pet::findOrFail($petId);
        $pet->name = $request->get('name');
        $pet->status = $request->get('status');
        $pet->save();

        DB::commit();

        return response()->json('', 200);
    }

    public function findById($petId)
    {
        $pet = Pet::where('id', $petId)->with(['category', 'tags', 'photos'])->firstOrFail();

        return response()->json($pet, 200);
    }

    public function remove($petId)
    {
        $pet = Pet::findOrFail($petId);

        foreach ($pet->photos as $photo) {
            Storage::disk('public')->delete($photo);
        }

        $pet->tags()->delete();
        $pet->photos()->delete();
        $pet->delete();

        return response()->json('', 200);
    }

    public function uploadImage(Request $request, $petId)
    {
        $validator = Validator::make($request->all(),
            [
                'file' => 'required|image|max:10240',
            ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 405);
        }

        $imageName = 'images/pet/' . rand() . time() . '.' . $request->image->getClientOriginalExtension();
        Storage::disk('public')->put($imageName, $request->file);

        $photo = new Photo();
        $photo->petId = $petId;
        $photo->photoUrl = url($imageName);
        $photo->additionalMetadata = $request->get('additionalMetadata');
        $photo->save();

        return response()->json('', 200);
    }
}