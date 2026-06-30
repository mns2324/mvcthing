<?php
class SiteUserController
{
    private $model;

    public function __construct($model)
    {
        // stores the Employees class into this object
        $this->model = $model;
    }
    public function login($username, $password)
    {
        // validate inputs before passing to the model, otherwise pass errorMsg to view
        $username = trim($username);
        $password = trim($password);

        if ($username === "" || $password === "") {
            return [
                'success' => false,
                'message' => 'Please enter both username and password.'
            ];
        }

        // pass to the model
        $user = $this->model->getWebUserByName($username);

        if (!$user || $password !== $user['password']) {
            return [
                'success' => false,
                'message' => 'Invalid username or password.'
            ];
        }

        return [
            'success' => true,
            'user' => $user
        ];
    }

    public function getWebUserByName($username)
    {
        return $this->model->getWebUserByName($username);
    }
}

?>