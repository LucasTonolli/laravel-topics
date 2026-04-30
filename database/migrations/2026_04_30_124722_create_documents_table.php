<?php

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Folder::class);
            $table->string('name');
            $table->string('path');
            $table->string('type');
            $table->float('size');
            $table->timestamps();
        });

        Schema::create('document_user', function (Blueprint $table) {
            $table->foreignIdFor(Document::class);
            $table->foreignIdFor(User::class);
            $table->string('permission')->default('view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
