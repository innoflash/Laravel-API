<?php

namespace Core\Loaders;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class ProvidersLoader
{

    /**
     * Loads only the Main Service Providers from the Containers.
     * All the Service Providers (registered inside the main), will be
     * loaded from the `boot()` function on the parent of the Main
     * Service Providers.
     *
     * @param $containerPath
     */
    public function loadMainProvidersFromComponent($containerPath)
    {
        $componentProvidersDirectory = $containerPath.'/Providers';
        $this->loadProviders($componentProvidersDirectory);
    }

    /**
     * @param $directory
     */
    private function loadProviders($directory)
    {
        if (File::isDirectory($directory)) {

            $files = File::allFiles($directory);

            foreach ($files as $file) {

                if (File::isFile($file)) {

                    $serviceProviderClass = static::getClassFullNameFromFile($file->getPathname());

                    $this->loadProvider($serviceProviderClass);
                }
            }
        }
    }

    /**
     * build and return an object of a class from its file path
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    public static function getClassObjectFromFile($filePathName)
    {
        $classString = self::getClassFullNameFromFile($filePathName);

        $object = new $classString;

        return $object;
    }

    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class"
     *
     * @param $filePathName
     *
     * @return  string
     */
    public static function getClassFullNameFromFile($filePathName)
    {
        return self::getClassNamespaceFromFile($filePathName).'\\'.self::getClassNameFromFile($filePathName);
    }

    /**
     * get the class name form file path using token
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    protected static function getClassNameFromFile($filePathName)
    {
        $php_code = file_get_contents($filePathName);

        $classes = [];
        $tokens  = token_get_all($php_code);
        $count   = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING
            ) {

                $class_name = $tokens[$i][1];
                $classes[]  = $class_name;
            }
        }

        return $classes[0];
    }

    /**
     * get the class namespace form file path using token
     *
     * @param $filePathName
     *
     * @return  null|string
     */
    protected static function getClassNamespaceFromFile($filePathName)
    {
        $src = file_get_contents($filePathName);

        $tokens       = token_get_all($src);
        $count        = count($tokens);
        $i            = 0;
        $namespace    = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace    = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }
        if (! $namespace_ok) {
            return null;
        } else {
            return $namespace;
        }
    }

    /**
     * @param $providerFullName
     */
    private function loadProvider($providerFullName)
    {
        App::register($providerFullName);
    }

    /**
     * Load the all the registered Service Providers on the Main Service Provider.
     *
     * @param array $serviceProviders
     *
     * @void
     */
    public function loadServiceProviders(array $serviceProviders)
    {
        foreach ($serviceProviders as $provider) {
            $this->loadProvider($provider);
        }
    }
}
