<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\Admin\BannerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $banners = $this->bannerService->getAllBanners();

        return view('admin.banners.index', compact('banners'));
    }

    public function toggleStatus($id, Request $request)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = $request->status;
        $banner->save();

        return response()->json(['message' => 'Banner status updated successfully']);
    }

    public function getData(Request $request)
    {
        $banners = Banner::all();

        return DataTables::of($banners)
            ->addColumn('image', function ($banner) {
                return $banner->image_url
                    ? Storage::disk('public')->url($banner->image_url)
                    : null;
            })
            ->addColumn('title', function ($banner) {
                return $banner->title ?? '';
            })
            ->addColumn('action', function ($banner) {
                return '';
            })
            ->make(true);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $this->bannerService->store($request);

        return redirect()->route('admin.banners.index')->with('success', __('cms.banners.created'));
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $this->bannerService->update($request, $id);

        return redirect()->route('admin.banners.index')->with('success', __('cms.banners.updated'));
    }

    public function destroy($id)
    {
        try {
            $this->bannerService->delete($id);

            return response()->json([
                'success' => true,
                'message' => __('cms.banners.deleted'),
            ]);
        } catch (\Exception $e) {
            Log::error("Error deleting banner with ID {$id}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the banner.',
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:banners,id',
            'status' => 'required|in:0,1',
        ]);

        try {
            $banner = Banner::findOrFail($request->id);

            $banner->status = $request->status;
            $banner->save();

            return response()->json([
                'success' => true,
                'message' => __('cms.banners.status_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating banner status.',
            ]);
        }
    }
}
