<?php

namespace components;

class Config
{
    /** @var array */
    private $configs = [];

    /**
     * @param string $configName
     * @return mixed
     */
    public function getRequired(string $configName)
    {
        if (!isset($this->configs[$configName])) {
            throw new \LogicException("Параметр \"$configName\" не найден");
        }

        return $this->configs[$configName];
    }

    /**
     * @param string $configName
     * @param null $default
     * @return mixed|null
     */
    public function get(string $configName, $default = null)
    {
        return $this->configs[$configName] ??  $default;
    }

    /**
     * @param string $configPath
     */
    public function loadConfig(string $configPath)
    {
        $configData = $this->getConfigData($configPath);
        $this->configs = array_replace($this->configs, $configData);
    }

    /**
     * @param string $configFilePath
     * @return array
     */
    public function getConfigData(string $configFilePath): array
    {
        $config = require($configFilePath);

        if (!is_array($config) || !$config) {
            throw new \LogicException("Ошибка загрузки файла конфигурации $configFilePath.
                Файл должен содержать массив параметров.");
        }

        return $config;
    }
}
