<?php

namespace App\Policies;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use \Illuminate\Auth\Access\Response;

class AdoptionPolicy{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function tester(User $user, Adoption $adoption) {
        if ($adoption->listed_by === $user->id) {
            return Response::deny('It is your own pet!', 403);
        }
        return Response::allow();
    }

}
