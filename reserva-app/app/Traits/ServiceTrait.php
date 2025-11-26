<?php

namespace App\Traits;

trait ServiceTrait
{
    protected $model;

    public function findById(int $id)
    {
        if (is_null($id)) {
            return null;
        }
        return $this->model->whereKey($id)->first();
    }

    private function model()
    {
        $path_service_class = explode('\\', get_class($this));

        if (empty($path_service_class)) {
            return null;
        }

        $model_class = str_replace(
            'Service',
            '',
            $path_service_class[count($path_service_class) - 1]
        );

        $model_class = str_replace(
            'Repository',
            '',
            $model_class
        );

        if (count($path_service_class) == 4) {
            $model_class = $path_service_class[2] . "\\" . $model_class;
        }

        if (count($path_service_class) == 5) {
            $model_class = $path_service_class[3] . "\\" . $model_class;
        }

        return "App\Models\\" . $model_class;
    }

    public function findByUuid(string $uuid)
    {
        if (is_null($uuid)) {
            return null;
        }
        return $this->model->whereUuid($uuid)->first();
    }

    public function count()
    {
        return $this->model->count();
    }

    private function applyCriteria($query, array $criteria = [], array $orWheres = [])
    {
        if (!empty($criteria)) {
            $query->where(function ($query) use ($criteria) {
                foreach ($criteria as $field => $value) {
                    $query->where($field, $value);
                }
            });
        }

        if (!empty($orWheres)) {
            $query->where(function ($query) use ($orWheres) {
                foreach ($orWheres as $field => $value) {
                    $query->orWhere($field, $value);
                }
            });
        }

        return $query;
    }

    private function applyOrders($query, array $orders = [])
    {
        if (!empty($orders)) {
            foreach ($orders as $field => $direction) {
                $query->orderBy($field, $direction);
            }
        }
        return $query;
    }
}
