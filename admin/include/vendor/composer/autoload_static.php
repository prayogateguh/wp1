<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9c0fe13929ce8032bf857710399ad669
{
    public static $files = array (
        '337663d83d8353cc8c7847676b3b0937' => __DIR__ . '/..' . '/kahlan/kahlan/src/functions.php',
        '64745745f6fbbc645762f24cc3e63d54' => __DIR__ . '/..' . '/maciejczyzewski/bottomline/bottomline.php',
    );

    public static $prefixLengthsPsr4 = array (
        '_' => 
        array (
            '__\\' => 3,
        ),
        'K' => 
        array (
            'Kahlan\\' => 7,
        ),
        'C' => 
        array (
            'Campo\\' => 6,
        ),
        'B' => 
        array (
            'Buchin\\GoogleImageGrabber\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        '__\\' => 
        array (
            0 => __DIR__ . '/..' . '/maciejczyzewski/bottomline/src',
        ),
        'Kahlan\\' => 
        array (
            0 => __DIR__ . '/..' . '/kahlan/kahlan/src',
        ),
        'Campo\\' => 
        array (
            0 => __DIR__ . '/..' . '/campo/random-user-agent/src',
        ),
        'Buchin\\GoogleImageGrabber\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        's' => 
        array (
            'stringEncode' => 
            array (
                0 => __DIR__ . '/..' . '/paquettg/string-encode/src',
            ),
        ),
        'P' => 
        array (
            'PHPHtmlParser' => 
            array (
                0 => __DIR__ . '/..' . '/thesoftwarefanatics/php-html-parser/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9c0fe13929ce8032bf857710399ad669::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9c0fe13929ce8032bf857710399ad669::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9c0fe13929ce8032bf857710399ad669::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
