<?php

namespace App\Services;

use App\Models\Source;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SourceService
{
    protected Source $model;

    public function __construct(Source $model)
    {
        $this->model = $model;
    }

    /**
     * Get all sources with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15 , $with = []): LengthAwarePaginator
    {
        return $this->model->with($with)->latest()->paginate($perPage);
    }

    /**
     * Get all sources without pagination
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find source by ID
     *
     * @param int $id
     * @return Source|null
     */
    public function findById(int $id): ?Source
    {
        return $this->model->find($id);
    }

    /**
     * Find source by ID or fail
     *
     * @param int $id
     * @return Source
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int $id): Source
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new source
     *
     * @param array $data
     * @return Source
     * @throws \Exception
     */
    public function create(array $data): Source
    {
        try {
            DB::beginTransaction();

            $source = $this->model->create($data);

            DB::commit();

            Log::info('Source created successfully', ['id' => $source->id]);

            return $source;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Source', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Update an existing source
     *
     * @param Source $source
     * @param array $data
     * @return Source
     * @throws \Exception
     */
    public function update(Source $source, array $data): Source
    {
        try {
            DB::beginTransaction();

            $source->update($data);
            $source->refresh();

            DB::commit();

            Log::info('Source updated successfully', ['id' => $source->id]);

            return $source;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Source', [
                'id' => $source->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete a source
     *
     * @param Source $source
     * @return bool
     * @throws \Exception
     */
    public function delete(Source $source): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $source->delete();

            DB::commit();

            Log::info('Source deleted successfully', ['id' => $source->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Source', [
                'id' => $source->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Search sources based on criteria
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
     * Bulk delete sources
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

            Log::info('Bulk delete sources completed', [
                'ids' => $ids,
                'deleted_count' => $deleted
            ]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete sources', [
                'ids' => $ids,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get sources by specific field
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
     * Count total sources
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if source exists
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get latest sources
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model->latest()->limit($limit)->get();
    }

    /**
     * Duplicate a source
     *
     * @param Source $source
     * @return Source
     * @throws \Exception
     */
    public function duplicate(Source $source): Source
    {
        try {
            DB::beginTransaction();

            $data = $source->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $newSource = $this->model->create($data);

            DB::commit();

            Log::info('Source duplicated successfully', [
                'original_id' => $source->id,
                'new_id' => $newSource->id
            ]);

            return $newSource;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating Source', [
                'id' => $source->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
