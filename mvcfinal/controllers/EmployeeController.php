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
        if (!is_numeric($emp_id) || $emp_id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid employee ID.'
            ];
        }

        // execute getEmpById() from the employees model class
        return $this->model->getEmpById($emp_id);
    }
    public function createEmp($firstname, $surname, $role, $payroll, $full_time)
    {
        // validate inputs before passing to the model, otherwise pass errorMsg to view
        if (
            trim($firstname) === "" ||
            trim($surname) === "" ||
            trim($role) === "" ||
            trim($payroll) === "" ||
            trim($full_time) === ""
        ) {
            return [
                'success' => false,
                'message' => "Don't leave any fields blank."
            ];
        }

        $full_time = strtolower(trim($full_time));

        if (
            $full_time !== "yes" &&
            $full_time !== "no" &&
            $full_time !== "1" &&
            $full_time !== "0"
        ) {
            return [
                'success' => false,
                'message' => "Type yes/no or 1/0 only."
            ];
        }

        $full_time = ($full_time === "yes" || $full_time === "1") ? 1 : 0;

        // pass to the model
        $this->model->createEmp($firstname, $surname, $role, $payroll, $full_time);

        return ['success' => true];
    }
    public function updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time)
    {
        // validate inputs before passing to the model, otherwise pass errorMsg to view
        if (
            trim($firstname) === "" ||
            trim($surname) === "" ||
            trim($role) === "" ||
            trim($payroll) === "" ||
            trim($full_time) === ""
        ) {
            return [
                'success' => false,
                'message' => "Don't leave any fields blank."
            ];
        }

        $full_time = strtolower(trim($full_time));

        if (
            $full_time !== "yes" &&
            $full_time !== "no" &&
            $full_time !== "1" &&
            $full_time !== "0"
        ) {
            return [
                'success' => false,
                'message' => "Type yes/no or 1/0 only."
            ];
        }

        $full_time = ($full_time === "yes" || $full_time === "1") ? 1 : 0;

        // pass to the model
        $this->model->updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time);

        return ['success' => true];
    }
    public function deleteEmp($emp_id)
    {
        if (!is_numeric($emp_id) || $emp_id <= 0) {
            return [
                'success' => false,
                'message' => 'Invalid employee ID.'
            ];
        }

        $this->model->deleteEmp($emp_id);

        return ['success' => true];
    }
}
