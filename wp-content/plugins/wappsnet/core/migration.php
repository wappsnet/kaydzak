<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 11.02.2018
 * Time: 0:53
 */

namespace Wappsnet\Core;


class Migration
{
    public static $migrationsPath = WAPPSNET_PATH."migrations/";

    /**
     * @param $migrationName
     * @param $migrationType
     */
    public static function up($migrationName, $migrationType) {
//    	if(WP_MODE == 'development') {
		    $migrationPath = self::$migrationsPath . $migrationType . "/" . $migrationName;

		    switch ( $migrationType ) {
			    case "sql":
				    $sqlData = file_get_contents( $migrationPath );
				    Database::getInstance()->query( $sqlData );
				    break;
		    }
//	    }
    }

    public static function down() {

    }
}