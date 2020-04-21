<?php

namespace components;

class View
{
    /** @var */
    private $layout;
    /** @var */
    private $templatesDir;

    /**
     * @param string $layout
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param string $templatesDir
     */
    public function setTemplatesDir(string $templatesDir)
    {
        $this->templatesDir = $templatesDir;
    }

    /**
     * @param string $templatePath
     * @param array $vars
     */
    public function render(string $templatePath, array $vars = [])
    {
        if (!$this->layout) {
            throw new \LogicException('Не указан layout');
        }

        $this->renderPart($this->layout, array_replace($vars, [
            'content' => $this->renderPartToSring($templatePath, $vars)
        ]));
    }

    /**
     * @param string $templatePath
     * @param array $vars
     * @throws \InvalidArgumentException
     */
    public function renderPart(string $templatePath, array $vars = [])
    {
        $templatePath = ($this->templatesDir)
            ? $this->templatesDir . DIRECTORY_SEPARATOR . $templatePath
            : $templatePath;

        $this->renderTemplate($templatePath, $vars);
    }

    /**
     * @param string $templatePath
     * @param array $vars
     * @return false|string
     */
    public function renderPartToSring(string $templatePath, array $vars = [])
    {
        ob_start();
        ob_implicit_flush(false);
        $this->renderPart($templatePath, $vars);

        return ob_get_clean();
    }

    /**
     * @param string $templatePath
     * @param array $vars
     */
    final private function renderTemplate(string $templatePath, array $vars = [])
    {
        if (!file_exists($templatePath)) {
            throw new \InvalidArgumentException("Шаблон $templatePath не найден");
        }

        $vars['view'] = $this;
        extract($vars, EXTR_PREFIX_SAME, 'var');
        require($templatePath);
    }
}
