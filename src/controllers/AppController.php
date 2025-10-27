<?php

class AppController {

    protected function render(string $template = null, array $variables = []) {

        $templatePath = 'public/views/'. $template.'.html';
        $templatePath404 = 'public/views/404.html';
        $output = "";
                 
        if(file_exists($templatePath)){
            // ["message" => "Hasło błedne"]
            extract($variables);
            // $message = "Hasło błedne"
            
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