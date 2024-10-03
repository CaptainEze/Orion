<?php
namespace OrionCore\Framework\Render;

// require "../vendor/autoload.php";


use eftec\bladeone\BladeOne;

class Render
{
    private $viewsDir, $cacheDir, $instance;

    public function __construct(string $views_directory, string $cache_directory)
    {
        $this->viewsDir = $views_directory;
        $this->cacheDir = $cache_directory;

        $this->instance = new BladeOne($this->viewsDir, $this->cacheDir, BladeOne::MODE_AUTO);
    }

    public function render(string $file_name, array $context = []): void
    {
        $this->instance->run($file_name, $context);
    }

}