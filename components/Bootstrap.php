<?php

namespace components;

class Bootstrap
{
    /**
     *
     */
    const CLASS_FILE_EXTENSION = 'php';

    /** @var array */
    private $namespacePrefixes = [];

    /** @var array */
    private $namespacePrefixesLenght = [];

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'loadClass'], true, true);
    }

    /**
     * @param string $namespace
     * @param string $dir
     */
    public function addNamespace(string $namespace, string $dir)
    {
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException('Директория не найдена');
        }

        $namespace = trim($namespace, '\\');
        $this->namespacePrefixes[$namespace] = realpath($dir);
        $this->namespacePrefixesLenght[$namespace] = strlen($namespace);
    }

    /**
     * @param string $class
     */
    public function loadClass(string $class)
    {
        foreach (array_keys($this->namespacePrefixes) as $prefix) {
            if (strpos($class, $prefix) === 0) {

                $baseDir = $this->namespacePrefixes[$prefix];
                $prefixLenght = $this->namespacePrefixesLenght[$prefix];

                $classRelativePath = strtr(
                    substr_replace($class, '', 0, $prefixLenght),
                    '\\',
                    DIRECTORY_SEPARATOR
                );

                $classPath = $baseDir . $classRelativePath . '.' . self::CLASS_FILE_EXTENSION;

                if (file_exists($classPath)) {
                    require_once $classPath;
                    break;
                }
            }
        }
    }
}
