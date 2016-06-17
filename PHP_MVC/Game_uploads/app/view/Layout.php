<?php


class Layout
{
    private $navBar;

    public function __construct()
    {
        $this->navBar = new \view\NavBar();
    }

    public function render($output)
    {

      echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <link rel="stylesheet" href="'.dirname($_SERVER['PHP_SELF']).'/css/style.css">
          <title>Login Example</title>
        </head>
        <body>

          <h1>GameTube</h1>

            ' . $this->navBar->navigationMenu() . '
          <div class="container">
            ' . $this->renderHTML($output) . '
          </div>
         </body>
      </html>
    ';

    }

    function renderHTML($output){
        if(is_array($output))
            return implode($output);
        else
            return $output;
    }

}