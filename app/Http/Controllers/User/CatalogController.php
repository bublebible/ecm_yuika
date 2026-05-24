<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with(['latestCondition', 'category']);

        // Check if category filter is active
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Check if search keyword is active
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $assets = $query->get();
        $categories = Category::withCount('assets')->get();
        return view('user.catalog.index', compact('assets', 'categories'));
    }

    public function show(Asset $asset)
    {
        $asset->load(['latestCondition', 'category', 'conditions']);
        return view('user.catalog.show', compact('asset'));
    }
}
