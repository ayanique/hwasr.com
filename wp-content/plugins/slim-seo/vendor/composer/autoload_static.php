<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit374ec2afc302a524a611d30a174d5a8f
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SlimSEO\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SlimSEO\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit374ec2afc302a524a611d30a174d5a8f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit374ec2afc302a524a611d30a174d5a8f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
