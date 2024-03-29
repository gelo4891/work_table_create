<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit51c62b33039390a900c5b3a02cd35a09
{
    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PHPExcel' => 
            array (
                0 => __DIR__ . '/..' . '/phpoffice/phpexcel/Classes',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit51c62b33039390a900c5b3a02cd35a09::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit51c62b33039390a900c5b3a02cd35a09::$classMap;

        }, null, ClassLoader::class);
    }
}
