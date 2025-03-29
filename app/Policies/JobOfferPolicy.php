<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobOfferPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, JobOffer $jobOffer)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasRole('recruiter') || $user->hasRole('admin');
    }

    public function update(User $user, JobOffer $jobOffer)
    {
        return $user->id === $jobOffer->recruiter_id || $user->hasRole('admin');
    }

    public function delete(User $user, JobOffer $jobOffer)
    {
        return $user->id === $jobOffer->recruiter_id || $user->hasRole('admin');
    }
}

