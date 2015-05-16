<?php
$array = array(
    'filelink' => "/media/{$media->basename}/{$media->filename}"
);
echo stripslashes(json_encode($array)); 
?>