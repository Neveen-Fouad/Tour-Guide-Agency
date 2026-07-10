<?php

namespace App\Policies;

use App\Models\Request as TourRequest;
use App\Models\Tourist;
use App\Models\TourGuide;

class TourRequestPolicy
{
    private function getUserRole($user): ?string
    {
        if ($user instanceof Tourist) {
            return 'tourist';
        }
        if ($user instanceof TourGuide) {
            return 'tour_guide';
        }
        try {
            $payload = auth()->payload();
            $role = $payload->get('role');
            return $role;
        } catch (\Exception $e) {
            return null;
        }
    }
        private function isAdmin($user): bool
    {
        return in_array($user->email, config('admin.emails'), true);
    }
    
    public function view($user, TourRequest $tourRequest): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }
        $role = $this->getUserRole($user);
        if ($role === 'tourist') {
            return $user->id === $tourRequest->Tourist_id;
        }
        if ($role === 'tour_guide') {
            return $user->id === $tourRequest->Tour_Guide_id;
        }
        return false;
    }

    public function create($user): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }
        return $this->getUserRole($user) === 'tourist';
    }

    public function update($user, TourRequest $tourRequest): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }
        if ($this->getUserRole($user) === 'tour_guide') {
            return $user->id === $tourRequest->Tour_Guide_id;
        }
        return false; 
    }

    public function delete($user, TourRequest $tourRequest): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }
        if ($this->getUserRole($user) === 'tourist') {
            return $user->id === $tourRequest->Tourist_id;
        }
        return false;
    }
}

