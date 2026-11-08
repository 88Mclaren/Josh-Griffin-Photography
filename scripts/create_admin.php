<?php
/*
 * Run from the project root in a terminal:
 * php scripts/create_admin.php admin@example.com "A-long-unique-password"
 * Delete this script after creating your first administrator.
 */
require_once dirname(__DIR__).'/config.php';
if(PHP_SAPI!=='cli'){http_response_code(403);exit("CLI only.\n");}
if($argc!==3 || !filter_var($argv[1],FILTER_VALIDATE_EMAIL) || strlen($argv[2])<14){
    fwrite(STDERR,"Usage: php scripts/create_admin.php email password (password must be 14+ characters)\n");exit(1);
}
$s=db()->prepare("INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,'admin')");
$s->execute(['Site Administrator',strtolower($argv[1]),password_hash($argv[2],PASSWORD_DEFAULT)]);
echo "Administrator created.\n";
