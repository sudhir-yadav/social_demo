@ECHO OFF
SET BIN_TARGET=%~dp0/../squizlabs/php_codesniffer/bin/phpcbf
php "%BIN_TARGET%" %*
