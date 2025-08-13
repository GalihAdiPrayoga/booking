<?php

namespace App\Observers;

use App\Models\User;
use Faker\Provider\Uuid;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $user->test_observer = Uuid::uuid();
     
    }
}
