<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable('name', 'slug', 'user_id')]
class Folder extends Model
{
    protected static function booted()
    {
        static::creating(function (Folder $folder) {
            $folder->slug = Str::slug($folder->name);
        });

        static::updating(function (Folder $folder) {
            if ($folder->isDirty('name')) {
                $folder->slug = Str::slug($folder->name);
            }
        });
    }
}
