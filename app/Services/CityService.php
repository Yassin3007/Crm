<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CityService
{
    protected City $model;

    public function __construct(City $model)
    {
        $this->model = $model;
    }

    /**
     * Get all cities with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15 , $with = []): LengthAwarePaginator
    {
        return $this->model->with($with)->latest()->paginate($perPage);
    }

    /**
     * Get all cities without pagination
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find city by ID
     *
     * @param int $id
     * @return City|null
     */
    public function findById(int $id): ?City
    {
        return $this->model->find($id);
    }

    /**
     * Find city by ID or fail
     *
     * @param int $id
     * @return City
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int $id): City
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new city
     *
     * @param array $data
     * @return City
     * @throws \Exception
     */
    public function create(array $data): City
    {
        try {
            DB::beginTransaction();

            $city = $this->model->create($data);

            DB::commit();

            Log::info('City created successfully', ['id' => $city->id]);

            return $city;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating City', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Update an existing city
     *
     * @param City $city
     * @param array $data
     * @return City
     * @throws \Exception
     */
    public function update(City $city, array $data): City
    {
        try {
            DB::beginTransaction();

            $city->update($data);
            $city->refresh();

            DB::commit();

            Log::info('City updated successfully', ['id' => $city->id]);

            return $city;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating City', [
                'id' => $city->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete a city
     *
     * @param City $city
     * @return bool
     * @throws \Exception
     */
    public function delete(City $city): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $city->delete();

            DB::commit();

            Log::info('City deleted successfully', ['id' => $city->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting City', [
                'id' => $city->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Search cities based on criteria
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
     * Bulk delete cities
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

            Log::info('Bulk delete cities completed', [
                'ids' => $ids,
                'deleted_count' => $deleted
            ]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete cities', [
                'ids' => $ids,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get cities by specific field
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
     * Count total cities
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if city exists
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get latest cities
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model->latest()->limit($limit)->get();
    }

    /**
     * Duplicate a city
     *
     * @param City $city
     * @return City
     * @throws \Exception
     */
    public function duplicate(City $city): City
    {
        try {
            DB::beginTransaction();

            $data = $city->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $newCity = $this->model->create($data);

            DB::commit();

            Log::info('City duplicated successfully', [
                'original_id' => $city->id,
                'new_id' => $newCity->id
            ]);

            return $newCity;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating City', [
                'id' => $city->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
