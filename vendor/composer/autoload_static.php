<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06249f88f3306d59fb50c46883a48205
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MonProjet\\GestionBudget\\' => 24,
        ),
        'C' => 
        array (
            'Config\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MonProjet\\GestionBudget\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06249f88f3306d59fb50c46883a48205::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06249f88f3306d59fb50c46883a48205::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit06249f88f3306d59fb50c46883a48205::$classMap;

        }, null, ClassLoader::class);
    }
}
