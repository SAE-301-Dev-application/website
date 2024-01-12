<?php

// Informations de connexion MySQL
$dbHost = 'localhost';
$dbUser = 'admin';
$dbPass = '4DDminF3.st1.plan1345a';
$dbName = 'bjharysm_festiplan';

// Informations de connexion FTP
$ftpHost = 'node97-eu.n0c.com';
$ftpUser = 'ftp@festiplan.go.yj.fr';
$ftpPass = ':(9~~6M:aa9zC8748h';
$ftpDir = '/home/bjharysm/';

// Chemin de sauvegarde local
$backupDir = '/db_backups';

// Nom du fichier de sauvegarde
$backupFile = 'backup_' . date('Ymd') . '.sql';

// Commande mysqldump
$command = "mysqldump -u $dbUser -p$dbPass -h $dbHost $dbName > $backupDir/$backupFile";
exec($command);

// Connexion FTP et transfert du fichier
$ftpCommand = "lftp -u $ftpUser,$ftpPass $ftpHost -e 'set ftp:ssl-allow no; cd $ftpDir; put $backupDir/$backupFile; bye'";

exec($ftpCommand);

echo "La sauvegarde de la base de données est terminée.";

?>