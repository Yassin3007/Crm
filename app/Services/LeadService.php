<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeadService
{
    protected Lead $model;

    public function __construct(Lead $model)
    {
        $this->model = $model;
    }

    /**
     * Get all leads with pagination
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
//    public function getAllPaginated(int $perPage = 15 , $with = [],): LengthAwarePaginator
//    {
//        return $this->model->with($with)->where()->latest()->paginate($perPage);
//    }
    public function getAllPaginated($perPage = 15, $with = [], $filters = [])
    {
        $query = $this->model->query();

        // Apply eager loading
        if (!empty($with)) {
            $query->with($with);
        }

        // Apply filters
        if (!empty($filters)) {

            // Name filter
            if (!empty($filters['name'])) {
                $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
            }

            // Phone filter
            if (!empty($filters['phone'])) {
                $query->where('phone', 'LIKE', '%' . $filters['phone'] . '%');
            }

            // Email filter
            if (!empty($filters['email'])) {
                $query->where('email', 'LIKE', '%' . $filters['email'] . '%');
            }

            // Source filter
            if (!empty($filters['source_id'])) {
                $query->where('source_id', $filters['source_id']);
            }

            // Branch filter
            if (!empty($filters['branch_id'])) {
                $query->where('branch_id', $filters['branch_id']);
            }

            // District filter
            if (!empty($filters['district_id'])) {
                $query->where('district_id', $filters['district_id']);
            }

            // Date range filter
            if (!empty($filters['date_from'])) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }
        }

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

    /**
     * Get all leads without pagination
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find lead by ID
     *
     * @param int $id
     * @return Lead|null
     */
    public function findById(int $id): ?Lead
    {
        return $this->model->find($id);
    }

    /**
     * Find lead by ID or fail
     *
     * @param int $id
     * @return Lead
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findByIdOrFail(int $id): Lead
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new lead
     *
     * @param array $data
     * @return Lead
     * @throws \Exception
     */
    public function create(array $data): Lead
    {
        try {
            DB::beginTransaction();

            $lead = $this->model->create($data);

            DB::commit();

            Log::info('Lead created successfully', ['id' => $lead->id]);

            return $lead;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Lead', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    /**
     * Update an existing lead
     *
     * @param Lead $lead
     * @param array $data
     * @return Lead
     * @throws \Exception
     */
    public function update(Lead $lead, array $data): Lead
    {
        try {
            DB::beginTransaction();

            $lead->update($data);
            $lead->refresh();

            DB::commit();

            Log::info('Lead updated successfully', ['id' => $lead->id]);

            return $lead;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Lead', [
                'id' => $lead->id,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Delete a lead
     *
     * @param Lead $lead
     * @return bool
     * @throws \Exception
     */
    public function delete(Lead $lead): bool
    {
        try {
            DB::beginTransaction();

            $deleted = $lead->delete();

            DB::commit();

            Log::info('Lead deleted successfully', ['id' => $lead->id]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Lead', [
                'id' => $lead->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Search leads based on criteria
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
     * Bulk delete leads
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

            Log::info('Bulk delete leads completed', [
                'ids' => $ids,
                'deleted_count' => $deleted
            ]);

            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete leads', [
                'ids' => $ids,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Get leads by specific field
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
     * Count total leads
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if lead exists
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get latest leads
     *
     * @param int $limit
     * @return Collection
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model->latest()->limit($limit)->get();
    }

    /**
     * Duplicate a lead
     *
     * @param Lead $lead
     * @return Lead
     * @throws \Exception
     */
    public function duplicate(Lead $lead): Lead
    {
        try {
            DB::beginTransaction();

            $data = $lead->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);

            $newLead = $this->model->create($data);

            DB::commit();

            Log::info('Lead duplicated successfully', [
                'original_id' => $lead->id,
                'new_id' => $newLead->id
            ]);

            return $newLead;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating Lead', [
                'id' => $lead->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
