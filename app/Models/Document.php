<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable('user_id', 'folder_id', 'name', 'path', 'type', 'size')]
class Document extends Model
{
    use HasUuids;

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user')->wherePivot('permission', 'edit');
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user')->wherePivot('permission', 'view');
    }

    public function sharedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user');
    }
}
