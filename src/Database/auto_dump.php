<?php
echo "Start of the database backup...<br><br>";

// MySQL login information -> TO CONFIGURE ACCORDING TO USED DATABASE (000Webhost for us)
$dbHost    = 'localhost';
$dbPort    = '3306';
$dbName    = 'festiplan';
$dbCharset = 'utf8mb4';
$dbUser    = 'root';
$dbPass    = 'root';
$options   = [																				 
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// FTP connection information
$ftpHost = '185.221.182.245';
$ftpUserName = 'ftp@festiplan.go.yj.fr';
$ftpPassword = ':(9~~6M:aa9zC8748h';

// Generate dump file name
$generatedFileName = 'backup_' . date('Ymd_hi') . '.sql';

// Local and remote file paths
$localBackupDirectory = $_SERVER["DOCUMENT_ROOT"] . "website/src/Database/db_backups/";
$localFilePath = $localBackupDirectory . $generatedFileName;

$remoteFilePath = "db_backups/$generatedFileName";

try
{
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=$dbCharset",
                   $dbUser, $dbPass, $options);

    // Open file for writing
    $file = fopen($localFilePath, 'w');

    // Get database creation SQL
    $databaseCreateQuery = $pdo->query("SHOW CREATE DATABASE $dbName");
    $databaseCreateResult = $databaseCreateQuery->fetch(PDO::FETCH_NUM);
    $databaseCreate = $databaseCreateResult[1];

    // Write database creation SQL to the file
    fwrite($file, "-- Database creation\n");
    fwrite($file, "$databaseCreate;\n\n");

    // Tables in the order of creation
    $tables = ["utilisateur", "festival", "grij", "scene", "categorie", "spectacle", "intervenant", "festival_utilisateur", "festival_scene", "festival_categorie", "festival_spectacle", "spectacle_categorie", "spectacle_intervenant"];

    // Use the database
    fwrite($file, "USE $dbName;\n\n");

    // Create tables and insert data
    foreach ($tables as $table) {
        // Structure
        $structureQuery = $pdo->query("SHOW CREATE TABLE $table");
        $structureResult = $structureQuery->fetch(PDO::FETCH_NUM);

        if ($structureResult) {
            $structure = $structureResult[1];
            fwrite($file, "-- Table structure for table `$table`\n");
            fwrite($file, "$structure;\n\n");

            // Data retrieval query
            $dataQuery = $pdo->query("SELECT * FROM $table");
            $rows = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                fwrite($file, "-- Data insertion for table `$table`\n");
                foreach ($rows as $row) {
                    $columns = implode(', ', array_keys($row));
                    $values = implode(', ', array_map(function ($value) use ($pdo) {
                        return ($value === null) ? 'NULL' : $pdo->quote($value);
                    }, $row));

                    fwrite($file, "INSERT INTO $table ($columns) VALUES ($values);\n");
                }
                fwrite($file, "\n");
            }
        } else {
            // Add debugging information
            echo "Failed to get structure for table: $table\n";
            print_r($pdo->errorInfo());
        }
    }

    // Close the file
    fclose($file);

    echo "Database backup successfully created at: $localFilePath<br><br>";

    // set up basic connection
    $ftp = ftp_connect($ftpHost);
    if (!$ftp) {
        throw new Exception("FTP connection failed");
    }

    // login with username and password
    $login_result = ftp_login($ftp, $ftpUserName, $ftpPassword);
    if (!$login_result) {
        throw new Exception("FTP login failed");
    }

    // switch to passive mode
    if (!ftp_pasv($ftp, true)) {
        throw new Exception("Failed to enable passive mode");
    }

    // check connection
    echo "Connected to $ftpHost, for user $ftpUserName<br><br>";

    // upload a file
    $upload_result = ftp_put($ftp, $remoteFilePath, $localFilePath, FTP_BINARY);
    if ($upload_result) {
        echo "Successfully uploaded $generatedFileName\n";
    } else {
        $error_message = error_get_last()['message'] ?? "Unknown error";
        throw new Exception("There was a problem while uploading $localFilePath. Error: $error_message");
    }

    // close the connection
    ftp_close($ftp);
} catch (Exception $e) {
    die("Error : " . $e->getMessage());
}