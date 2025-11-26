<?php

namespace App\Traits;

trait RequestFiltersTrait
{
    private const LIKE_FIELDS = ['title', 'name', 'email'];
    private const OR_FIELDS = ['title', 'email'];
    private const EXACT_FIELDS = ['status', 'user_id', 'role', 'code'];

    public function prepareFilters(array $filters, array $fieldMapping = []): array
    {
        $defaultMapping = [
            'name' => 'name',
            'email' => 'email',
            'status' => 'status',
            'user_id' => 'usuario_id',
            'role' => 'role',
            'code' => 'id'
        ];

        $mapping = array_merge($defaultMapping, $fieldMapping);
        $criteria = [];
        $orWhere = [];

        foreach ($filters as $field => $value) {
            if (empty($value)) {
                continue;
            }

            $mappedField = $mapping[$field] ?? $field;

            if (in_array($field, self::OR_FIELDS)) {
                $orWhere[] = [
                    'field' => $mappedField,
                    'operator' => 'like',
                    'value' => "%{$value}%"
                ];
                continue;
            }

            $criteria[$mappedField] = $value;
        }

        return [
            'criteria' => $criteria,
            'orWhere' => $orWhere,
        ];
    }
}
