<?php

namespace App\Http\Controllers;

use App\Helpers\DecisionTree;
use App\Helpers\LaptopConstant;
use App\Http\Resources\LaptopResource;
use App\Models\Laptop;
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
        $screenSizes = Laptop::distinct()->orderBy('screen_size')->pluck('screen_size')->all();
        $cpus = Laptop::distinct()->orderBy('cpu')->pluck('cpu')->all();
        $storages = Laptop::distinct()->orderBy('storage')->pluck('storage')->all();

        return view('pages.guest.filter', compact('categories', 'manufacturers', 'screenSizes', 'cpus', 'storages'));
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

        if ($request->has('storage') && $request->get('storage')) {
            $qb->whereIn('storage', $request->get('storage'));
        }

        if ($request->has('screen_size') && $request->get('screen_size')) {
            $qb->whereIn('screen_size', $request->get('screen_size'));
        }

        if ($request->has('cpu') && $request->get('cpu')) {
            $qb->whereIn('cpu', $request->get('cpu'));
        }

        sleep(2);

        $response = $qb->get();

        return response()->json(['items' => LaptopResource::collection($response)]);
    }
}
