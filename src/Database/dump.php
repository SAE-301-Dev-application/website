<?php
echo "Start of the database backup...<br><br>";

$backup_dir = $_SERVER["DOCUMENT_ROOT"] . 'website/src/Database/db_backups/';

// Informations de connexion MySQL
$dbHost = 'localhost';
// $dbUser = 'admin';
// $dbPass = '4DDminF3.st1.plan1345a';
// $dbName = 'bjharysm_festiplan';
$dbName = 'festiplan';
$dbUser = 'root';
$dbPass = 'root';

// Informations de connexion FTP
$ftp_server = '185.221.182.245';
$ftp_user_name = 'ftp@festiplan.go.yj.fr';
$ftp_user_pass = ':(9~~6M:aa9zC8748h';

$file_name = 'backup_' . date('Ymd_hi') . '.sql';

$server_file_path = "db_backups/$file_name";
$local_backup_file = $backup_dir . $file_name;

try
{
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

    $query = $pdo->prepare("SELECT * INTO OUTFILE '$local_backup_file' FROM utilisateur");
    
    $query->execute();

    // set up basic connection
    $ftp = ftp_connect($ftp_server);
    if (!$ftp) {
        throw new Exception("FTP connection failed");
    }

    // login with username and password
    $login_result = ftp_login($ftp, $ftp_user_name, $ftp_user_pass);
    if (!$login_result) {
        throw new Exception("FTP login failed");
    }

    // switch to passive mode
    if (!ftp_pasv($ftp, true)) {
        throw new Exception("Failed to enable passive mode");
    }

    // check connection
    echo "Connected to $ftp_server, for user $ftp_user_name<br><br>";

    // upload a file
    $upload_result = ftp_put($ftp, $server_file_path, $local_backup_file, FTP_BINARY);
    if ($upload_result) {
        echo "Successfully uploaded $local_backup_file\n";
    } else {
        $error_message = error_get_last()['message'] ?? 'Unknown error';
        throw new Exception("There was a problem while uploading $local_backup_file. Error: $error_message");
    }

    // close the connection
    ftp_close($ftp);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>