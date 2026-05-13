<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

use App\Models\Category;

class CatalogController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['latestCondition', 'category'])->get();
        $categories = Category::withCount('assets')->get();
        return view('user.catalog.index', compact('assets', 'categories'));
    }

    public function show(Asset $asset)
    {
        $asset->load(['latestCondition', 'category', 'conditions']);
        return view('user.catalog.show', compact('asset'));
    }
}
