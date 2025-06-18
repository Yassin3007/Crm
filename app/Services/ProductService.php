<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Get all products with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15 , $with = []): LengthAwarePaginator
    {
        return $this->model->with($with)->latest()->paginate($perPage);
    }

    /**
     * Get all products without pagination
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find product by ID
     *
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id): ?Product
    {
        return $this->model->find($id);
    }

    /**
     * Find product by ID or fail
     *
     * @param int $id
     * @return Product
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int $id): Product
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function create(array $data): Product
    {
        try {
            DB::beginTransaction();

            $product = $this->model->create($data);

            DB::commit();

            Log::info('Product created successfully', ['id' => $product->id]);

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Product', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Update an existing product
     *
     * @param Product $product
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function update(Product $product, array $data): Product
    {
        try {
            DB::beginTransaction();

            $product->update($data);
            $product->refresh();

            DB::commit();

            Log::info('Product updated successfully', ['id' => $product->id]);

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Product', [
                'id' => $product->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete a product
     *
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $product->delete();

            DB::commit();

            Log::info('Product deleted successfully', ['id' => $product->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Product', [
                'id' => $product->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Search products based on criteria
     *
     * @param array $criteria
     * @return LengthAwarePaginator
     */
    public function search(array $criteria): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Add search logic based on your model's searchable fields
        // Example implementation:
        if (isset($criteria['search']) && !empty($criteria['search'])) {
            $searchTerm = $criteria['search'];
            $query->where(function ($q) use ($searchTerm) {
                // Add searchable columns here
                // $q->where('name', 'LIKE', "%{$searchTerm}%")
                //   ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Add date range filtering
        if (isset($criteria['start_date']) && !empty($criteria['start_date'])) {
            $query->whereDate('created_at', '>=', $criteria['start_date']);
        }

        if (isset($criteria['end_date']) && !empty($criteria['end_date'])) {
            $query->whereDate('created_at', '<=', $criteria['end_date']);
        }

        // Add sorting
        $sortBy = $criteria['sort_by'] ?? 'created_at';
        $sortOrder = $criteria['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $criteria['per_page'] ?? 15;
        return $query->paginate($perPage);
    }

    /**
     * Bulk delete products
     *
     * @param array $ids
     * @return int
     * @throws \Exception
     */
    public function bulkDelete(array $ids): int
    {
        try {
            DB::beginTransaction();

            $deleted = $this->model->whereIn('id', $ids)->delete();

            DB::commit();

            Log::info('Bulk delete products completed', [
                'ids' => $ids,
                'deleted_count' => $deleted
            ]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete products', [
                'ids' => $ids,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get products by specific field
     *
     * @param string $field
     * @param mixed $value
     * @return Collection
     */
    public function getByField(string $field, $value): Collection
    {
        return $this->model->where($field, $value)->get();
    }

    /**
     * Count total products
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if product exists
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get latest products
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model->latest()->limit($limit)->get();
    }

    /**
     * Duplicate a product
     *
     * @param Product $product
     * @return Product
     * @throws \Exception
     */
    public function duplicate(Product $product): Product
    {
        try {
            DB::beginTransaction();

            $data = $product->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $newProduct = $this->model->create($data);

            DB::commit();

            Log::info('Product duplicated successfully', [
                'original_id' => $product->id,
                'new_id' => $newProduct->id
            ]);

            return $newProduct;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating Product', [
                'id' => $product->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
