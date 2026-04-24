<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCondition;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::with('latestCondition')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
        }

        $assets = $query->paginate(10);
        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.assets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:assets',
            'category_id' => 'required|exists:categories,id',
            'price_per_day' => 'required|numeric',
            'stock_qty' => 'required|integer',
            'condition_status' => 'required|string', // Good, Damaged
            'condition_notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $asset = Asset::create($request->only('name', 'code', 'category_id', 'description', 'price_per_day', 'stock_qty'));

        $conditionData = [
            'version' => 1,
            'status' => $request->condition_status,
            'notes' => $request->condition_notes,
            'created_by_user_id' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $conditionData['image'] = $request->file('image')->store('conditions', 'public');
        }

        $asset->conditions()->create($conditionData);

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        $asset->load('conditions.creator');
        $categories = Category::all();
        return view('admin.assets.edit', compact('asset', 'categories'));
    }

    public function update(Request $request, Asset $asset)
    {
        // Basic Update
        if ($request->has('update_info')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'price_per_day' => 'required|numeric',
                'stock_qty' => 'required|integer',
            ]);
            $asset->update($request->all());
            return back()->with('success', 'Informasi aset berhasil diperbarui.');
        }

        // New Version Update
        if ($request->has('new_version')) {
            $request->validate([
                'status' => 'required|string',
                'notes' => 'nullable|string',
            ]);

            $latestVersion = $asset->conditions()->max('version') ?? 0;
            
            $conditionData = [
                'version' => $latestVersion + 1,
                'status' => $request->status,
                'notes' => $request->notes,
                'created_by_user_id' => Auth::id(),
            ];

            if ($request->hasFile('image')) {
                $conditionData['image'] = $request->file('image')->store('conditions', 'public');
            }

            $asset->conditions()->create($conditionData);

            return back()->with('success', 'Versi kondisi baru berhasil ditambahkan.');
        }
        
        return back();
    }
}
