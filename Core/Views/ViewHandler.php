<?php

namespace Core\Views;


class ViewHandler
{
    // todo
    //  make composite view Object in Controller ?


    public static function doSomething($name, $params = [])
    {
        // todo give params to views
        $view = new View($name, $params);
        self::renderHTML($view);
    }

    private function renderHTML(View $view) // todo add subviews
    {
        ob_start();
        echo '<!DOCTYPE html><html><body>';
        self::renderView($view);
        echo '</body></html>';
        echo ob_get_clean();
    }

    private function renderView(View $view)
    {
        // unpacking parameters . e.g. instead of $params['article']->name use $article->name
        foreach ($view->getParams() as $key => $value){
            $$key = $value;
        }
        require $view->getFileLocation();
    }
}

class View
{
    private string $name;
    private array $params;
    private string $location;

    public function
    __construct(string $name, array $params)
    {
        $this->name = $name;
        $this->params = $params;

        $this->location = $this->resolveTemplate();
    }

    /**
     * Resolve path to generated view from template
     * @return string
     * @throws \Exception
     */
    private function resolveTemplate(): string
    {
        // todo move to config ? fix path's inconsistency !
        $config_view_dir = '../views/source/';
        $config_view_cache_dir = '../views/final/';

        if (true) { // todo add logic ... if file is .template.php
            // using name 'blade' is for the sake of convenience its nothing close to a templating engine
            $viewLocation = $config_view_dir . $this->name . '.blade.php';
            $viewCacheLocation = $config_view_cache_dir . $this->name . '.php'; //todo throw exceptions

            if (!file_exists($viewLocation))
                throw new \Exception('view file is missing, path = ' . $viewLocation);
            if (!file_exists($config_view_cache_dir) && !is_dir($config_view_cache_dir))
                throw new \Exception('view cache folder is missing' . $config_view_cache_dir);

            $content = file_get_contents($viewLocation);

            $content = str_replace('{{-', '<?php ', $content);
            $content = str_replace('{{', '<?php echo ', $content);
            $content = str_replace('}}', ' ?>', $content);

            if (empty($content))
                throw new \Exception('view corruption detected');

            file_put_contents($viewCacheLocation, $content);
            return $viewCacheLocation;
        }
    }

    public function getFileLocation(): string
    {
        return $this->location;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}