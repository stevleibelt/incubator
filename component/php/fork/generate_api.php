#!/bin/php
<?php
//clean
shell_exec('/usr/bin/rm -fr document/*');
//and rebuild
system('php vendor/bin/apigen.php --source source/Net/Bazzline/Component/ForkManager/ --destination document/ --title "Fork Manager by Bazzline"');
