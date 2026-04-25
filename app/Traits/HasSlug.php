<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     * Laravel automatically calls methods starting with "boot" + TraitName.
     */
    protected static function bootHasSlug(): void
    {
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('name')) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug already exists in the table
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-".$count++;
        }

        return $slug;
    }
}
