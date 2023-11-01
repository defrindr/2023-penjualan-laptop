<?php

namespace App\Http\Controllers;

use App\Helpers\DecisionTree;
use App\Http\Resources\LaptopResource;
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
}
