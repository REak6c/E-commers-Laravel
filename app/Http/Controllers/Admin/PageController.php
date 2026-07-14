<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    public function data(Request $request)
    {
        $pages = Page::select('pages.*');

        return DataTables::of($pages)
            ->addColumn('translated_title', fn ($page) => $page->title ?? '')
            ->addColumn('action', function ($page) {
                $editRoute = route('admin.pages.edit', $page->id);

                return '<div class="d-flex justify-content-end gap-2">
                            <a href="'.$editRoute.'" class="btn-action-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn-action-delete" onclick="deletePage('.$page->id.')" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>';
            })
            ->editColumn('status', fn ($page) => $page->status
                ? '<span class="badge bg-success-soft">Active</span>'
                : '<span class="badge bg-secondary-soft">Inactive</span>'
            )
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function getPages(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Page::query())->make(true);
        }
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string|min:5',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $title = $request->input('title');
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pages', 'public');
        }

        Page::create([
            'slug'      => $slug,
            'title'     => $title,
            'content'   => $request->input('content'),
            'image_url' => $imagePath,
            'status'    => $request->status ?? 1,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = $page->image_url;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('pages', 'public');
        }

        $page->update([
            'title'     => $request->input('title'),
            'content'   => $request->input('content'),
            'image_url' => $imagePath,
            'status'    => $request->status ?? 1,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        Page::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Page deleted successfully.']);
    }

    public function updatePageStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:pages,id',
            'status' => 'required|boolean',
        ]);

        Page::find($request->id)->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Page status updated.']);
    }
}
