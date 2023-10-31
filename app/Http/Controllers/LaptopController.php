<?php

namespace App\Http\Controllers;

use App\Helpers\LaptopConstant;
use App\Models\Laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LaptopController extends Controller
{
  public function index()
  {
    $title = 'Category List';
    $items = Laptop::orderBy('id', 'desc')->get();
    $manufacturers = LaptopConstant::listManufacturers();
    // sort manufacturers by name
    usort($manufacturers, function ($a, $b) {
      return $a > $b;
    });
    $categories = LaptopConstant::listCategories();
    // sort manufacturers by name
    usort($categories, function ($a, $b) {
      return $a > $b;
    });
    return view('pages.admin.laptop.index', compact('title', 'items', 'manufacturers', 'categories'));
  }

  public function show(Laptop $laptop)
  {
    return response()->json(['message' => 'Success retrieve data', 'data' => $laptop], 200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'manufacturer'             => 'required',
      'category'                 => 'required',
      'model_name'               => 'required',
      'screen_size'              => 'required',
      'screen'                   => 'required',
      'cpu'                      => 'required',
      'ram'                      => 'required',
      'storage'                  => 'required',
      'gpu'                      => 'required',
      'operating_system'         => 'required',
      'weight'                   => 'required',
      'price'                    => 'required',
    ]);

    if ($validator->fails()) return response()->json(['message' => $validator->messages()->first()], 400);

    $payload = $request->only([
      'manufacturer',
      'model_name',
      'category',
      'screen_size',
      'screen',
      'cpu',
      'ram',
      'storage',
      'gpu',
      'operating_system',
      'operating_system_version',
      'weight',
      'price',
    ]);

    try {
      $success = Laptop::create($payload);

      if (!$success) return response()->json(['message' => 'Failed to process payload'], 400);
      return response()->json(['message' => 'Success save data']);
    } catch (\Throwable $th) {
      Log::critical($th);
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function update(Request $request, Laptop $laptop)
  {
    $validator = Validator::make($request->all(), [
      'manufacturer'             => 'required',
      'category'                 => 'required',
      'model_name'               => 'required',
      'screen_size'              => 'required',
      'screen'                   => 'required',
      'cpu'                      => 'required',
      'ram'                      => 'required',
      'storage'                  => 'required',
      'gpu'                      => 'required',
      'operating_system'         => 'required',
      'weight'                   => 'required',
      'price'                    => 'required',
    ]);

    if ($validator->fails()) return response()->json(['message' => $validator->messages()->first()], 400);

    $payload = $request->only([
      'manufacturer',
      'model_name',
      'category',
      'screen_size',
      'screen',
      'cpu',
      'ram',
      'storage',
      'gpu',
      'operating_system',
      'operating_system_version',
      'weight',
      'price',
    ]);

    try {
      $success = $laptop->update($payload);

      if (!$success) return response()->json(['message' => 'Failed to process payload'], 400);
      return response()->json(['message' => 'Success update data']);
    } catch (\Throwable $th) {
      Log::critical($th);
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }

  public function destroy(Laptop $laptop)
  {
    try {
      $laptop->delete();
      return response()->json(['message' => 'Success remove data']);
    } catch (\Throwable $th) {
      Log::critical($th);
      return response()->json(['message' => $th->getMessage()], 500);
    }
  }
}
