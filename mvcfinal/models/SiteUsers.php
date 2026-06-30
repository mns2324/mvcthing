<?php
class SiteUsers
{
    // variables declared without datatypes become "properties" of this class, use $this-> to call/assign them
    private $db;
    private $table = 'site_users';

    public function __construct($db)
    {
        // instead of creating its own db connection, it stores the Database class into this object
        // this enables "$this->db" to use the methods found in the Database class without importing
        $this->db = $db;
    }

    public function getWebUserByName($username)
    {
        $query = "select * from $this->table where username = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("s", $username);
        // execute then get the records
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}

?>