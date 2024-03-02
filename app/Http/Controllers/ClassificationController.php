<?php

namespace App\Http\Controllers;

use App\Helpers\DecisionTree;
use App\Helpers\DecisionTreeClassifier;
use App\Helpers\LaptopConstant;
use App\Http\Resources\LaptopResource;
use App\Models\Laptop;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
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

        $dataSet = Laptop::all();

        $classification = new DecisionTreeClassifier();
        $classification->fit($dataSet);
        $response = $classification->predict(
            $this->build($request)
        );

        return response()->json(['items' => LaptopResource::collection($response)]);
    }

    protected function build(Request $request)
    {
        $filter = [];
        if ($request->has('manufactur')) {
            $filter['manufacturer'] = $request->get('manufactur');
        }

        if ($request->has('categories')) {
            $filter['category'] = $request->get('categories');
        }

        if ($request->has('minimum_price') && $request->get('minimum_price')) {
            $filter['price'] = $request->get('minimum_price');
        }

        if ($request->has('maximum_price') && $request->get('maximum_price')) {
            $filter['price'] = $request->get('maximum_price');
        }

        if ($request->has('ram') && $request->get('ram')) {
            $filter['ram'] = $request->get('ram');
        }

        if ($request->has('storage') && $request->get('storage')) {
            $filter['storage'] = $request->get('storage');
        }

        if ($request->has('screen_size') && $request->get('screen_size')) {
            $filter['screen_size'] = $request->get('screen_size');
        }

        if ($request->has('cpu') && $request->get('cpu')) {
            $filter['cpu'] = $request->get('cpu');
        }

        return $filter;
    }
}
