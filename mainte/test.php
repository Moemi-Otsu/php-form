<?php
// パスワードを記録したファイルの場所
echo __FILE__;
// /Applications/MAMP/htdocs/udemyphp/mainte/test.php

// パスワード（暗号化）
echo '<br>';
echo(password_hash('password123', PASSWORD_BCRYPT));
// $2y$10$btz2vTTTszQthyQ9fwPcYua/Uy9IStUyF17F544vOn8NQ181mdw3G