<?php

// The Model component corresponds to all the data-related logic that the user works with. 
// This can represent either the data that is being transferred between the View and Controller components or any other business logic-related data. 
// It can add or retrieve data from the database. It responds to the controller's request because the controller can't interact with the database by itself. 
// The model interacts with the database and gives the required data back to the controller.

class Employees
{
    // variables declared without datatypes become "properties" of this class, use $this-> to call/assign them
    private $db;
    private $table = 'employees';

    public function __construct($db)
    {
        // instead of creating its own db connection, it stores the Database class into this object
        // this enables "$this->db" to use the methods found in the Database class without importing
        $this->db = $db;
    }
    public function getAllEmps()
    {
        $query = "SELECT * FROM $this->table";
        // connect to the db and execute the query with this one line
        $result = $this->db->getConnection()->query($query);

        // result has a num_rows attribute: if its larger than 0, fetch all the records
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function getEmpById($emp_id)
    {
        $query = "SELECT * FROM $this->table WHERE emp_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        // assign int to id
        $stmt->bind_param("i", $emp_id);
        // execute then get the records
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    public function createEmp($firstname, $surname, $role, $payroll, $full_time)
    {
        $query = "INSERT INTO $this->table (firstname, surname, role, payroll, full_time) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        // assign the correct datatypes to the vars (use int for booleans)
        $stmt->bind_param("sssdi", $firstname, $surname, $role, $payroll, $full_time);
        return $stmt->execute();
    }

    public function updateEmp($emp_id, $firstname, $surname, $role, $payroll, $full_time)
    {
        $query = "UPDATE $this->table SET firstname = ?, surname = ?, role = ?, payroll = ?, full_time = ? WHERE emp_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        // assign the correct datatypes to the vars (use int for booleans)
        $stmt->bind_param("sssdii", $firstname, $surname, $role, $payroll, $full_time, $emp_id);
        return $stmt->execute();
    }

    public function deleteEmp($emp_id)
    {
        $query = "DELETE FROM $this->table WHERE emp_id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        // assign the correct datatypes to the vars 
        $stmt->bind_param("i", $emp_id);
        return $stmt->execute();
    }
}