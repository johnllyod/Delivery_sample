<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit16e5253351d0b32738b1aaa9ac3c028f
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit16e5253351d0b32738b1aaa9ac3c028f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit16e5253351d0b32738b1aaa9ac3c028f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit16e5253351d0b32738b1aaa9ac3c028f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
