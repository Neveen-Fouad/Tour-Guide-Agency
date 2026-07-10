<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\Tourist;
use App\Models\TourGuide;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    public function view($user, Review $review): bool
    {
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        if ($isAdmin) {
            return true;
        }
        
        return false;
    }

    // /**
    //  * Determine whether the user can create models.
    //  */
    public function create($user, Review $review): bool
    {
        
        if ($user instanceof Tourist) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Review $review): bool
    {
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        
        if ($isAdmin) {
            return false; 
        }

        if ($user instanceof Tourist) {
            return $user->id === $review->Tourist_id;
        }

   
        if ($user instanceof TourGuide) {

            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete($user, Review $review): bool
    {
        if ($user instanceof Tourist) {
            return $user->id === $review->Tourist_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Review $review): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Review $review): bool
    // {
    //     return false;
    // }
}
