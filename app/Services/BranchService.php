<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchService
{
    protected Branch $model;

    public function __construct(Branch $model)
    {
        $this->model = $model;
    }

    /**
     * Get all branches with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15 , $with = []): LengthAwarePaginator
    {
        return $this->model->with($with)->latest()->paginate($perPage);
    }

    /**
     * Get all branches without pagination
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find branch by ID
     *
     * @param int $id
     * @return Branch|null
     */
    public function findById(int $id): ?Branch
    {
        return $this->model->find($id);
    }

    /**
     * Find branch by ID or fail
     *
     * @param int $id
     * @return Branch
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int $id): Branch
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new branch
     *
     * @param array $data
     * @return Branch
     * @throws \Exception
     */
    public function create(array $data): Branch
    {
        try {
            DB::beginTransaction();

            $branch = $this->model->create($data);

            DB::commit();

            Log::info('Branch created successfully', ['id' => $branch->id]);

            return $branch;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Branch', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Update an existing branch
     *
     * @param Branch $branch
     * @param array $data
     * @return Branch
     * @throws \Exception
     */
    public function update(Branch $branch, array $data): Branch
    {
        try {
            DB::beginTransaction();

            $branch->update($data);
            $branch->refresh();

            DB::commit();

            Log::info('Branch updated successfully', ['id' => $branch->id]);

            return $branch;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Branch', [
                'id' => $branch->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete a branch
     *
     * @param Branch $branch
     * @return bool
     * @throws \Exception
     */
    public function delete(Branch $branch): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $branch->delete();

            DB::commit();

            Log::info('Branch deleted successfully', ['id' => $branch->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Branch', [
                'id' => $branch->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Search branches based on criteria
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
     * Bulk delete branches
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

            Log::info('Bulk delete branches completed', [
                'ids' => $ids,
                'deleted_count' => $deleted
            ]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete branches', [
                'ids' => $ids,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get branches by specific field
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
     * Count total branches
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if branch exists
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get latest branches
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model->latest()->limit($limit)->get();
    }

    /**
     * Duplicate a branch
     *
     * @param Branch $branch
     * @return Branch
     * @throws \Exception
     */
    public function duplicate(Branch $branch): Branch
    {
        try {
            DB::beginTransaction();

            $data = $branch->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $newBranch = $this->model->create($data);

            DB::commit();

            Log::info('Branch duplicated successfully', [
                'original_id' => $branch->id,
                'new_id' => $newBranch->id
            ]);

            return $newBranch;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating Branch', [
                'id' => $branch->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
