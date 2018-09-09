<?php

use App\Models\User;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Auth user
     */
    protected function authUser()
    {
        $user = User::where('email', 'goran.dimitrovski@outlook.com')->first();
        $user->api_key = base64_encode(str_random(40));
        $user->save();
        $this->be($user);
    }
}
