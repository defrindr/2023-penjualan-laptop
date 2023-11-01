<?php

namespace App\Http\Controllers;

use App\Helpers\DecisionTree;
use App\Helpers\LaptopConstant;
use App\Http\Resources\LaptopResource;
use App\Models\Laptop;
use App\Models\User;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{

  public function index()
  {
    $questions = DecisionTree::questions();
    return view('pages.guest.classification', compact('questions'));
  }

  public function analyst(Request $request)
  {

    $response = DecisionTree::result($request->get('answers'));
    sleep(2);

    return response()->json(['items' => LaptopResource::collection($response)]);
  }


  public function filter()
  {
    $categories = LaptopConstant::listCategories();
    $manufacturers = LaptopConstant::listManufacturers();
    return view('pages.guest.filter', compact('categories', 'manufacturers'));
  }

  public function filterAnalyst(Request $request)
  {

    $qb = Laptop::query();

    if ($request->has('manufactur')) {
      $qb->whereIn('manufacturer', $request->get('manufactur'));
    }

    if ($request->has('categories')) {
      $qb->whereIn('category', $request->get('categories'));
    }


    if ($request->has('minimum_price') && $request->get('minimum_price')) {
      $qb->where('price', '>', $request->get('minimum_price'));
    }

    if ($request->has('maximum_price') && $request->get('maximum_price')) {
      $qb->where('price', '<=', $request->get('maximum_price'));
    }


    if ($request->has('ram') && $request->get('ram')) {
      $qb->where('ram', $request->get('ram'));
    }

    sleep(2);

    $response = $qb->get();

    return response()->json(['items' => LaptopResource::collection($response)]);
  }
}
