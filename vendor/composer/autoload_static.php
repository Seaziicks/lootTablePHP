<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbb1adb74b544095f7a0a7c80bb70dd2b
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbb1adb74b544095f7a0a7c80bb70dd2b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbb1adb74b544095f7a0a7c80bb70dd2b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbb1adb74b544095f7a0a7c80bb70dd2b::$classMap;

        }, null, ClassLoader::class);
    }
}