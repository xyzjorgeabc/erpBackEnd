<?php
require_once __DIR__.'/../db.php';

$dbc = ConexionDatabase::get_instancia();

$q = <<<SQL
SELECT * from global_settings;
SQL;

$settings_stm = $dbc->prepare($q);
$settings_stm->execute();
$settings = $settings_stm->fetchAll()[0];
$settings['logo'] = stripslashes($settings['logo']);
echo json_encode($settings);
