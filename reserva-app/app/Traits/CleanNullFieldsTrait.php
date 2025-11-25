<?php

namespace App\Traits;

trait CleanNullFieldsTrait
{
    /**
     * Campos que podem ser null (têm defaults no banco/model)
     */
    protected array $nullableWithDefaults = [
        'status',
    ];

    /**
     * Override fill para remover apenas campos null que têm defaults
     */
    public function fill(array $attributes)
    {
        $cleanAttributes = [];
        foreach ($attributes as $key => $value) {
            // Remove apenas campos null que têm defaults
            if (is_null($value) && in_array($key, $this->nullableWithDefaults)) {
                continue;
            }
            $cleanAttributes[$key] = $value;
        }

        return parent::fill($cleanAttributes);
    }
}
