<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;
use App\Models\SuperAdmin;
use App\Models\ShopOwner;

class MultiUserProvider implements UserProvider
{
    protected $hasher;
    protected $model;

    public function __construct($hasher, $model)
    {
        // dd($model);
        $this->hasher = $hasher;
        $this->model = SuperAdmin::class;
    }

    public function retrieveById($identifier)
    {
        $user = SuperAdmin::find($identifier);

        if (!$user) {
            $user = ShopOwner::find($identifier);
        }

        return $user;
    }
    public function retrieveByToken($identifier, $token)
    {
        // Implement logic to retrieve user by token if needed
        // You can omit this method if token-based authentication is not used
    }

    public function updateRememberToken($user, $token)
    {
        // Implement logic to update remember token if needed
        // You can omit this method if remember token functionality is not used
    }

    public function retrieveByCredentials(array $credentials)
    {
        $email = $credentials['email'];
        $user = $this->createModel()->where('email', $email)->first();
    
        return $user;
    }

    protected function createModel()
{
    return new $this->model();
}

    public function validateCredentials($user, array $credentials)
    {
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    // Implement other UserProvider methods if needed
    // ...

}