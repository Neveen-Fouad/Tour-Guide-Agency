<?php

namespace App\Policies;

use App\Models\Request as TourRequest;
use App\Models\Tourist;
use App\Models\TourGuide;

class TourRequestPolicy
{
    public function view($user, TourRequest $tourRequest): bool
    {
         $isAdmin = in_array($user->email, config('admin.emails'), true);
        if ($isAdmin) {
            return true;
        }
        if ($user instanceof Tourist) {
            return $user->id === $tourRequest->Tourist_id;
        }
        if ($user instanceof TourGuide) {
            return $user->id === $tourRequest->Tour_Guide_id;
        }
        return false;
    }

    public function create($user): bool
    {
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        if ($isAdmin) {
            return false;
        }
        if ($user instanceof Tourist) {
            return true;
        }
        return false;
    }

    public function update($user, TourRequest $tourRequest): bool
    {
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        if ($isAdmin) {
            return true;
        }
        if ($user instanceof TourGuide) {
            return $user->id === $tourRequest->Tour_Guide_id;
        }
        return false; 
    }

    public function delete($user, TourRequest $tourRequest): bool
    {
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        if ($isAdmin) {
            return true;
        }
        if ($user instanceof Tourist) {
            return $user->id === $tourRequest->Tourist_id;
        }
        return false;
    }
}

