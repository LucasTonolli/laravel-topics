<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return $this->isOwner($user, $document) || $this->isViewer($user, $document) || $this->isEditor($user, $document);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $this->isOwner($user, $document) || $this->isEditor($user, $document);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $this->isOwner($user, $document);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }

    public function share(User $user, Document $document): bool
    {
        return $this->isOwner($user, $document);
    }

    public function download(User $user, Document $document): bool
    {
        return $this->isOwner($user, $document) || $this->isViewer($user, $document) || $this->isEditor($user, $document);
    }

    private function isOwner(User $user, Document $document): bool
    {
        return $user->id === $document->user_id;
    }

    private function isEditor(User $user, Document $document): bool
    {
        return $user->sharedDocuments()->where('id', $document->id)
            ->wherePivot('permission', 'edit')->exists();
    }

    private function isViewer(User $user, Document $document): bool
    {
        return $user->sharedDocuments()->where('id', $document->id)
            ->wherePivot('permission', 'view')->exists();
    }
}
