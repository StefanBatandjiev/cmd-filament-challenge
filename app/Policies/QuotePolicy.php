<?php

namespace App\Policies;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuotePolicy
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
    public function view(User $user, Quote $quote): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Quote $quote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Quote $quote): bool
    {
        return false;
    }

    public function approve(User $user, Quote $quote): bool
    {
        return $quote->status === QuoteStatus::PENDING;
    }

    public function reject(User $user, Quote $quote): bool
    {
        return $quote->status === QuoteStatus::PENDING;
    }

    public function schedule(User $user, Quote $quote): bool
    {
        return $quote->status === QuoteStatus::APPROVED;
    }

    public function invoice(User $user, Quote $quote): bool
    {
        return $quote->status === QuoteStatus::SCHEDULED;
    }
}
