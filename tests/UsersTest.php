<?php

class UsersTest extends TestCase
{
    /**
     * /api/token [GET]
     */
    public function testAuthenticate()
    {
        $parameters = [
            'email' => 'goran.dimitrovski@outlook.com',
            'password' => 'secret'
        ];
        $this->post("api/token", $parameters, []);
        var_dump($this->response->getContent());
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'api_key'
            ]
        );
    }

    /**
     * /api/account [GET]
     */
    public function testAccount()
    {
        $this->authUser();
        $this->get("api/account", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                "first_name",
                "last_name",
                "email",
            ]
        );
    }
}