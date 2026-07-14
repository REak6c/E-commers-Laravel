<?php

namespace App\Repositories\Shared\Product;

interface ProductRepositoryInterface
{
    public function all();

    public function find($id);

    /**
     * NOTE: store() and update() are defined here for interface completeness but are
     * intentionally not called by controllers. Controllers handle product creation and
     * updates directly via Eloquent inside DB transactions for fine-grained control
     * over variants, attribute values, and images. Only destroy() is used at runtime.
     */
    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}
