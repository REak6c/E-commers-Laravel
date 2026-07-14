<?php

namespace App\Repositories\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function store($data)
    {
        $slug = Str::slug($data['name'] ?? 'category');

        $imagePath = null;
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $data['image']->store('categories', 'public');
        }

        return Category::create([
            'slug'        => $slug,
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'image_url'   => $imagePath,
            'status'      => $data['status'] ?? true,
        ]);
    }

    public function update($id, array $data)
    {
        $category = $this->find($id);

        $imagePath = $category->image_url;
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $data['image']->store('categories', 'public');
        }

        $category->update([
            'name'        => $data['name'] ?? $category->name,
            'description' => $data['description'] ?? $category->description,
            'image_url'   => $imagePath,
            'status'      => $data['status'] ?? $category->status,
        ]);

        return $category;
    }

    public function destroy($id)
    {
        $category = $this->find($id);

        if ($category->image_url) {
            \Storage::disk('public')->delete($category->image_url);
        }

        return $category->delete();
    }

    public function storeWithTranslations(array $translations)
    {
        // $translations['en'] holds name, description, image (UploadedFile)
        $en = $translations['en'] ?? reset($translations);
        $slug = Str::slug($en['name']);

        $imagePath = null;
        if (isset($en['image']) && $en['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $en['image']->store('categories', 'public');
        }

        return Category::create([
            'slug'        => $slug,
            'name'        => $en['name'],
            'description' => $en['description'] ?? null,
            'image_url'   => $imagePath,
        ]);
    }

    public function updateWithTranslations(Category $category, array $translations)
    {
        $en = $translations['en'] ?? reset($translations);

        if (empty($en['name'])) {
            return $category;
        }

        $imagePath = $category->image_url;
        if (isset($en['image']) && $en['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $en['image']->store('categories', 'public');
        }

        $category->update([
            'name'        => $en['name'],
            'description' => $en['description'] ?? null,
            'image_url'   => $imagePath,
        ]);

        return $category;
    }
}
