<?php

namespace App\Repositories\Admin\Attribute;

use App\Models\Attribute;

class AttributeRepository implements AttributeRepositoryInterface
{
    public function getAll()
    {
        return Attribute::with('values')->latest()->paginate(10);
    }

    public function getById($id)
    {
        return Attribute::with('values')->findOrFail($id);
    }

    public function store(array $data)
    {
        $attribute = Attribute::create(['name' => $data['name']]);

        foreach ($data['values'] as $value) {
            $attribute->values()->create(['value' => $value]);
        }

        return $attribute;
    }

    public function update(Attribute $attribute, array $data)
    {
        $attribute->update(['name' => $data['name']]);

        $attribute->values()->delete();

        foreach ($data['values'] as $value) {
            $attribute->values()->create(['value' => $value]);
        }

        return $attribute;
    }

    public function delete($id)
    {
        return Attribute::findOrFail($id)->delete();
    }
}
