<?php

// The controller is the component that enables the interconnection between the views and the model so it acts as an intermediary. 
// The controller doesn’t have to worry about handling data logic, it just tells the model what to do. 
// It processes all the business logic and incoming requests, manipulates data using 
// the Model component, and interact with the View to render the final output.

class EmployeeController
{

    private $model;

    public function __construct($model)
    {
        // stores the Employees class into this object
        $this->model = $model;
    }
    public function getAllEmps()
    {
        // execute getAllEmps() from the employees model class
        return $this->model->getAllEmps();
    }
    public function getEmpById($emp_id)
    {
        // execute getEmpById() from the employees model class
        return $this->model->getEmpById($emp_id);
    }
    public function createEmp($firstname, $surname, $role, $payroll, $full_time)
    {
        // execute createEmp() from the employees model class
        return $this->model->createEmp($firstname, $surname, $role, $payroll, $full_time);
    }
    public function updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time)
    {
        // execute updateEmp() from the employees model class
        return $this->model->updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time);
    }
    public function deleteEmp($emp_id)
    {
        // execute deleteEmp() from the employees model class
        return $this->model->deleteEmp($emp_id);
    }
}
