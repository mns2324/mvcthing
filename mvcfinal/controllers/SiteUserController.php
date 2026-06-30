<?php
class SiteUserController
{
    private $model;

    public function __construct($model)
    {
        // stores the Employees class into this object
        $this->model = $model;
    }

    public function getWebUserByName($username)
    {
        return $this->model->getWebUserByName($username);
    }
}

?>