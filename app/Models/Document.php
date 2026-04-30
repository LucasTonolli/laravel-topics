<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable('folder_id', 'name', 'path', 'type', 'size')]
class Document extends Model
{
    use HasUuids;
}
