<?php
spl_autoload_register(function ($class) {
    $isClass = explode('\\', $class);

    if($isClass[0] == "Wappsnet") {
        $path = strtolower( $class );
        $path = explode( '\\', $path );

        array_shift( $path );

        $path = __DIR__.DIRECTORY_SEPARATOR.implode( DIRECTORY_SEPARATOR, $path ).'.php';

        if (file_exists( $path )) {
            require_once $path;
        }
    } else if($isClass[0] == "Modules") {
        $path = strtolower( $class );
        $path = str_replace( '-', '_',  $path );
        $path = explode( '\\', $path );
        $file = array_pop( $path );
        $path = implode( DIRECTORY_SEPARATOR, $path ) . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'index.php';

        $theme_dir = get_template_directory().DIRECTORY_SEPARATOR;
        $files_dir = $theme_dir . $path;

        if ( file_exists( $files_dir ) ) {
            require_once $files_dir;
        }
    } else if($isClass[0] == "Layouts") {
        $path = strtolower( $class );
        $path = str_replace( '-', '_',  $path );
        $path = explode( '\\', $path );
        $file = array_pop( $path );
        $path = implode( DIRECTORY_SEPARATOR, $path ) . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'index.php';

        $theme_dir = get_template_directory().DIRECTORY_SEPARATOR;
        $files_dir = $theme_dir . $path;

        if ( file_exists( $files_dir ) ) {
            require_once $files_dir;
        }
    } else if($isClass[0] == "Plugins") {
        $path = strtolower( $class );
        $path = str_replace( '-', '_',  $path );
        $path = explode( '\\', $path );
        $file = array_pop( $path );
        $path = implode(DIRECTORY_SEPARATOR, $path ) . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR . 'index.php';

        $theme_dir = get_template_directory().DIRECTORY_SEPARATOR;
        $files_dir = $theme_dir . $path;

        if ( file_exists( $files_dir ) ) {
            require_once $files_dir;
        }
    } else if($isClass[0] == "Widgets") {
        $path = strtolower( $class );
        $path = str_replace( '-', '_',  $path );
        $path = explode( '\\', $path );
        $file = array_pop( $path );
        $path = implode(DIRECTORY_SEPARATOR, $path ) . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR.'index.php';
        $file = dirname(__FILE__).DIRECTORY_SEPARATOR.$path;

        if (file_exists($file)) {
            require_once $file;
        }
    }
});
