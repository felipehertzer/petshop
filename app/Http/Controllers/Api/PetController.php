<?php


namespace App\Http\Controllers\Api;


use App\Category;
use App\Exceptions\ApiResponse;
use App\Http\Controllers\Controller;
use App\Pet;
use App\Photo;
use App\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Function that create or update a pet
     * @param Request $request
     * @param null $petId
     * @throws ApiResponse
     */
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
            if (!is_numeric($petId)) {
                throw new ApiResponse('Invalid ID supplied', 400);
            }
            try {
                $pet = Pet::findOrFail($petId);
                $pet->tags()->delete();
                $pet->photoUrls()->delete();
            } catch (ModelNotFoundException $e) {
                throw new ApiResponse('Pet not found', 404);
            }
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
            $netPhoto->additionalMetadata = '';
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

    /**
     * Validate and create a new pet
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
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
            throw new ApiResponse('Invalid Input', 405);
        }

        DB::beginTransaction();

        self::createOrUpdate($request);

        DB::commit();

        return response()->json('', 200);
    }

    /**
     * Validate and update a pet
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
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
            throw new ApiResponse('Validation exception', 405);
        }

        DB::beginTransaction();

        self::createOrUpdate($request, $request->get('id'));

        DB::commit();

        return response()->json('', 200);
    }

    /**
     * Find By Tags - Array
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
    public function findByTags(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'tags' => 'required|array',
            ]);
        if ($validator->fails()) {
            throw new ApiResponse('Invalid tag value', 400);
        }

        $pet = Pet::whereHas('tags', fn($q) => $q->whereIn('name', array_map('strtolower', $request->get('tags'))))
            ->with(['category', 'tags', 'photoUrls'])->get();

        return response()->json($pet, 200);
    }

    /**
     * Update a pet using form data
     * @param Request $request
     * @param $petId
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
    public function updateByForm(Request $request, $petId)
    {
        if (!is_numeric($petId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }

        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'status' => 'required|in:available,pending,sold',
            ]);
        if ($validator->fails()) {
            throw new ApiResponse('Invalid Input', 405);
        }

        try {
            DB::beginTransaction();

            $pet = Pet::findOrFail($petId);
            $pet->name = $request->get('name');
            $pet->status = $request->get('status');
            $pet->save();

            DB::commit();

            return response()->json('', 200);
        } catch (ModelNotFoundException $e) {
            throw new ApiResponse('Pet not found', 404);
        }
    }

    /**
     * Find pet by Id
     * @param $petId
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
    public function findById($petId)
    {
        if (!is_numeric($petId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }

        try {
            $pet = Pet::where('id', $petId)->with(['category', 'tags', 'photoUrls'])->firstOrFail();
            return response()->json($pet, 200);
        } catch (ModelNotFoundException $e) {
            throw new ApiResponse('Pet not found', 404);
        }
    }

    /**
     * delete pet by id
     * @param $petId
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
    public function remove($petId)
    {
        if (!is_numeric($petId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }
        try {
            $pet = Pet::findOrFail($petId);

            DB::beginTransaction();

            foreach ($pet->photoUrls as $photo) {
                Storage::disk('public')->delete($photo);
            }

            $pet->tags()->delete();
            $pet->photoUrls()->delete();
            $pet->delete();

            DB::commit();

            return response()->json('', 200);
        } catch (ModelNotFoundException $e) {
            throw new ApiResponse('Pet not found', 404);
        }
    }

    /**
     * Upload a pet's photo
     * @param Request $request
     * @param $petId
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponse
     */
    public function uploadImage(Request $request, $petId)
    {
        if (!is_numeric($petId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }

        $validator = Validator::make($request->all(),
            [
                'file' => 'required|image|max:10240',
            ]);
        if ($validator->fails()) {
            throw new ApiResponse('Invalid Input', 405);
        }

        $imageName = rand() . time() . '.' . $request->file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('images/pets/', $request->file, $imageName);

        $photo = new Photo();
        $photo->petId = $petId;
        $photo->photoUrl = url('images/pets/' . $imageName);
        $photo->additionalMetadata = $request->get('additionalMetadata') || '';
        $photo->save();

        return response()->json('', 200);
    }
}
