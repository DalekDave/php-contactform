<?php
/**
 * This file is used to write the submitted record to a file.
 */
use Iris\Config;

class FileHandler
{

    function insertRecord($userName, $userEmail, $telephone, $website, $address, $department, $hearAbout, $priority, $message)
    {
        $file = fopen(Config::CSV_FILE_NAME, "w");
        $post = array(
            array(
                "Name",
                "Email",
                "Telephone",
                "Website",
                "Address",
                "Department",
                "Hear About",
                "Priority",
                "Message"
            ),
            array(
                $userName,
                $userEmail,
                $telephone,
                $website,
                $address,
                $department,
                $hearAbout,
                $priority[0],
                $message
            )
        );

        foreach ($post as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
    }
}
