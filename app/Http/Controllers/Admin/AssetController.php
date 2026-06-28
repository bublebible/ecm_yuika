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
            'wig_image' => 'nullable|image|max:2048',
            'acc_image' => 'nullable|image|max:2048',
            'is_visible' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama kostum wajib diisi.',
            'code.required' => 'Kode kostum wajib diisi.',
            'code.unique' => 'Kode kostum ini sudah digunakan. Silakan gunakan kode unik yang lain (tidak boleh kembar).',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'price_per_day.required' => 'Harga sewa per hari wajib diisi.',
            'price_per_day.numeric' => 'Harga sewa per hari harus berupa angka.',
            'stock_qty.required' => 'Stok awal wajib diisi.',
            'stock_qty.integer' => 'Stok awal harus berupa angka bulat.',
            'condition_status.required' => 'Kondisi awal wajib dipilih.',
            'image.image' => 'File foto kostum harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'image.max' => 'Ukuran foto kostum tidak boleh melebihi 2MB.',
            'wig_image.image' => 'File foto wig harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'wig_image.max' => 'Ukuran foto wig tidak boleh melebihi 2MB.',
            'acc_image.image' => 'File foto aksesoris harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'acc_image.max' => 'Ukuran foto aksesoris tidak boleh melebihi 2MB.',
        ]);

        $assetData = $request->only('name', 'code', 'category_id', 'description', 'price_per_day', 'stock_qty');
        $assetData['is_visible'] = $request->has('is_visible');
        $asset = Asset::create($assetData);

        $conditionData = [
            'version' => 1,
            'status' => $request->condition_status,
            'notes' => $request->condition_notes,
            'created_by_user_id' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $conditionData['image'] = $request->file('image')->store('conditions', 'public');
        }

        if ($request->hasFile('wig_image')) {
            $conditionData['wig_image'] = $request->file('wig_image')->store('conditions', 'public');
        }

        if ($request->hasFile('acc_image')) {
            $conditionData['acc_image'] = $request->file('acc_image')->store('conditions', 'public');
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
            ], [
                'name.required' => 'Nama kostum wajib diisi.',
                'category_id.required' => 'Kategori wajib dipilih.',
                'category_id.exists' => 'Kategori yang dipilih tidak valid.',
                'price_per_day.required' => 'Harga sewa per hari wajib diisi.',
                'price_per_day.numeric' => 'Harga sewa per hari harus berupa angka.',
                'stock_qty.required' => 'Stok wajib diisi.',
                'stock_qty.integer' => 'Stok harus berupa angka bulat.',
            ]);
            $data = $request->all();
            $data['is_visible'] = $request->has('is_visible');
            $asset->update($data);
            return back()->with('success', 'Informasi aset berhasil diperbarui.');
        }

        // New Version Update
        if ($request->has('new_version')) {
            $request->validate([
                'status' => 'required|string',
                'notes' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'wig_image' => 'nullable|image|max:2048',
                'acc_image' => 'nullable|image|max:2048',
            ], [
                'status.required' => 'Status kondisi fisik wajib dipilih.',
                'image.image' => 'File foto kostum baru harus berupa gambar (jpeg, png, jpg, gif, svg).',
                'image.max' => 'Ukuran foto kostum baru tidak boleh melebihi 2MB.',
                'wig_image.image' => 'File foto wig baru harus berupa gambar (jpeg, png, jpg, gif, svg).',
                'wig_image.max' => 'Ukuran foto wig baru tidak boleh melebihi 2MB.',
                'acc_image.image' => 'File foto aksesoris baru harus berupa gambar (jpeg, png, jpg, gif, svg).',
                'acc_image.max' => 'Ukuran foto aksesoris baru tidak boleh melebihi 2MB.',
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

            if ($request->hasFile('wig_image')) {
                $conditionData['wig_image'] = $request->file('wig_image')->store('conditions', 'public');
            }

            if ($request->hasFile('acc_image')) {
                $conditionData['acc_image'] = $request->file('acc_image')->store('conditions', 'public');
            }

            $asset->conditions()->create($conditionData);

            return back()->with('success', 'Versi kondisi baru berhasil ditambahkan.');
        }
        
        return back();
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'Kostum berhasil dihapus.');
    }
}
