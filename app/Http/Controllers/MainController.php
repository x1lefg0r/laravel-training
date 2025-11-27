<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    public function index()
    {
        $jsonPath = public_path('articles.json');

        if (! File::exists($jsonPath)) {
            return view('welcome', ['items' => []]);
        }

        $jsonData = File::get($jsonPath);
        $data = json_decode($jsonData, true);

        return view('welcome', ['items' => $data ?? []]);
    }

    public function gallery($index)
    {
        $jsonPath = public_path('articles.json');

        if (! File::exists($jsonPath)) {
            return view('welcome', ['items' => []]);
        }

        $jsonData = File::get($jsonPath);
        $items = json_decode($jsonData, true);

        if (! isset($items[$index])) {
            abort(404);
        }

        return view('gallery', ['item' => $items[$index], 'index' => $index]);
    }
}
