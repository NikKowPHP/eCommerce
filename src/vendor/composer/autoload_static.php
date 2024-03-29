<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit675644e99b7222bba6f7c21c3752ab58
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Controllers\\' => 16,
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Models',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/Controllers',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit675644e99b7222bba6f7c21c3752ab58::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit675644e99b7222bba6f7c21c3752ab58::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit675644e99b7222bba6f7c21c3752ab58::$classMap;

        }, null, ClassLoader::class);
    }
}
