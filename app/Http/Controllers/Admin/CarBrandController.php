<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarBrand\StoreCarBrandRequest;
use App\Http\Requests\Admin\CarBrand\UpdateCarBrandRequest;
use App\Http\Resources\Admin\CarBrand\ListingCarBrandResource;
use App\Http\Resources\Admin\CarBrand\ShowCarBrandResource;
use App\Models\CarBrand;
use App\Traits\APIResponse;
use App\Traits\UploadHelper;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    use APIResponse, UploadHelper;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carBrands = CarBrand::query();

        if ($request->search) {
            $carBrands->where('name_ar', 'like', '%'. $request->search .'%')
                ->orWhere('name_en', 'like', '%'. $request->search .'%');
        }

        $carBrands = $carBrands->get();

        return $this->successResponse(ListingCarBrandResource::collection($carBrands));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarBrandRequest $request)
    {
        $image = null;
        if($request->image){
            $image = $this->upload($request->image, 'car-brands');
        }

        CarBrand::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $image,
        ]);

        return $this->successResponse(null, 'Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $carBrand = CarBrand::findOrFail($id);

        return $this->successResponse(new ShowCarBrandResource($carBrand));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarBrandRequest $request, $id)
    {
        $carBrand = CarBrand::findOrFail($id);

        $carBrand->name_ar = $request->name_ar;
        $carBrand->name_en = $request->name_en;
        if($request->image){
            $carBrand->image = $this->upload($request->image, 'car-brands');
        }
        $carBrand->save();

        return $this->successResponse(null, 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carBrand = CarBrand::findOrFail($id);
        $carBrand->delete();

        return $this->successResponse(null,'Deleted Successfully');
    }
}
