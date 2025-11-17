<?php

class AppController {

    protected function isGet(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'GET';
    }

    protected function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] === 'POST';
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.html';
        $templatePath404 = 'public/views/404.html';
        
        // Extract variables so they're available in the template
        extract($variables);
        
        if (file_exists($templatePath)) {
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        } else {
            ob_start();
            include $templatePath404;
            $output = ob_get_clean();
        }
        
        echo $output;
    }
}