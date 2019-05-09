<?php

define("DB_ENGINE","mysql");
define("DB_HOST","localhost");
define("DB_USER","phpmyadmin");
define("DB_PASSWORD","root");
define("DB_NAME","guest_book");

if( !defined( 'TOKEN_SALT' ) ) { define( 'TOKEN_SALT', 'am?EKIO@!FJ9U cW+ea@+zcQQ&4Hp+eA3}q<ST^V.BN-yZ]e)5C]H[p!v/8.`@mH' );}
if( !defined( 'PASSWORD_ARGON2_DEFAULT_MEMORY_COST' ) ) { define( 'PASSWORD_ARGON2_DEFAULT_MEMORY_COST', 2048 );}
if( !defined( 'PASSWORD_ARGON2_DEFAULT_TIME_COST' ) ) { define( 'PASSWORD_ARGON2_DEFAULT_TIME_COST', 4 );}
if( !defined( 'PASSWORD_ARGON2_DEFAULT_THREADS' ) ) { define( 'PASSWORD_ARGON2_DEFAULT_THREADS', 3 );}
if( !defined( 'ATTEMPTS_NUMBER' ) ) { define( 'ATTEMPTS_NUMBER', 3 );}
