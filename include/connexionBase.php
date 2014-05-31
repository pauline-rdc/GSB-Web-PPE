<?php 
try

{
    $bdd = new PDO('mysql:host=sql.franceserv.com; dbname=pauline-rdc_db4', 'pauline-rdc', 'Maeve24');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

?>