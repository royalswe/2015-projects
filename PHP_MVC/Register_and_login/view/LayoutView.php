<?php


class LayoutView
{
    private $registerURL = "register";


    public function render($isLoggedIn, $view)
    {
        $dtv = new DateTimeView();

        echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>

          <h1>Assignment 2</h1>

          ' . $this->renderURL($view) . '

          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $view->response() . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
    }

    private function renderIsLoggedIn($isLoggedIn)
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        } else {
            return '<h2>Not logged in</h2>';
        }
    }

    /**
     * @param $view
     * @return string from class name
     */
    private function renderURL($view)
    {
        if (get_class($view) == 'LoginView') {
            return "<a href='?" . $this->registerURL . "'>Register a new user</a>";
        } elseif (get_class($view) == 'RegisterView') {
            return "<a href='?'>Back to login</a>";
        }
    }

}
