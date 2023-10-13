<?php
namespace Iris;

/**
 * Generic datasource class for handling DB operations.
 * Uses MySqli and PreparedStatements.
 *
 * @version 2.4 - added JSON return type for inserts
 */
class DataSource
{

    // PHP 7.1.0 visibility modifiers are allowed for class constants.
    // when using above 7.1.0, declare the below constants as private
    const HOST = 'localhost';

    const USERNAME = 'root';

    const PASSWORD = '';

    const DATABASENAME = 'iris';

    private $conn;

    /**
     * PHP implicitly takes care of cleanup for default connection types.
     * So no need to worry about closing the connection.
     *
     * Singletons not required in PHP, as there is no
     * concept of shared memory.
     * Every object lives only for a request.
     */
    function __construct()
    {
        $this->conn = $this->getConnection();
    }

    /**
     * If connection object is needed, use this method and get access to it.
     * Otherwise, use the below methods for insert / update / etc.
     *
     * @return \mysqli
     */
    public function getConnection()
    {
        $conn = new \mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);

        if (mysqli_connect_errno()) {
            trigger_error("Problem with connecting to database.");
        }

        $conn->set_charset("utf8");
        return $conn;
    }

    /**
     * Insert the submitted data into the database table as a record.
     *
     * @param string $userName
     * @param string $userEmail
     * @param string $telephone
     * @param string $department
     * @param string $website
     * @param string $address
     * @param string $hearAbout
     * @param string $priority
     * @param string $message
     * @param string $copyUser
     * @param string $token
     * @param string $isGdpr
     */
    function insertContact($userName, $userEmail, $telephone, $department, $website, $address, $hearAbout, $priority, $message, $copyUser, $token, $isGdpr)
    {
        $aboutUs = '';
        if (! empty($hearAbout)) {
            $aboutUs = implode(', ', $hearAbout);
            $priorityvalue = implode(', ', $hearAbout);
        }
        $priorityvalue = "";
        if (! empty($priority)) {
            $priorityvalue = implode(', ', $priority);
        }
        $st = $this->conn->prepare("INSERT INTO tbl_contact (name, email, telephone, department, website, address, hear_about_us, priority, message, copy_user, attachment_folder, is_gdpr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $st->bind_param("ssssssssssss", $userName, $userEmail, $telephone, $department, $website, $address, $aboutUs, $priorityvalue, $message, $copyUser, $token, $isGdpr);
        $st->execute();
        $st->close();
    }
}
