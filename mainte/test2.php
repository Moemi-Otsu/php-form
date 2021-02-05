<?php

$contactFile = '.contact.dat';

// ファイル丸ごと読み込み
$fileContents = file_get_contents($contactFile);

// echo $fileContents;

// ファイルに書き込み
file_put_contents()