<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit146ac58b110c979632a140abf50d802e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Config' => __DIR__ . '/../..' . '/app/Config.php',
        'App\\SQLiteConnection' => __DIR__ . '/../..' . '/app/SQLiteConnection.php',
        'App\\SQLiteCreateTable' => __DIR__ . '/../..' . '/app/SQLiteCreateTable.php',
        'App\\SQLiteInsert' => __DIR__ . '/../..' . '/app/SQLiteInsert.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit146ac58b110c979632a140abf50d802e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit146ac58b110c979632a140abf50d802e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit146ac58b110c979632a140abf50d802e::$classMap;

        }, null, ClassLoader::class);
    }
}
