<?php

namespace App\Transformers;

// We need to reference the Items Model
use App\Models\User;

// Dingo includes Fractal to help with transformations
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
//    protected $defaultIncludes = ['roles'];
    public function transform(User $user)
    {
        // specify what elements are going to be visible to the API
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'gender' => $user->gender,
            'birth_date' => $user->birth_date,
            'address' => $user->address,
            'roles' => $user->roles,
            'rent_limit' => $user->rent_limit,
            'is_phone_verified' => $user->is_phone_verified
        ];
    }

}
