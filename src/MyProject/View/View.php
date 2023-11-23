<?php

namespace MyProject\View;

class View
{
    private array $extraVars = [];

    public function __construct(private string $templatesPath)
    {
    }

    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], int $code = 200): void
    {
        http_response_code($code);
        extract($this->extraVars);
        extract($vars);
        if (!isset($title)) {
            $title = null;
        }
        ob_start();
        include $this->templatesPath . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}