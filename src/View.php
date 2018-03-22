<?php

namespace Ueef\Owlet {

    use Ueef\Owlet\Interfaces\ViewInterface;
    use Ueef\Owlet\Interfaces\EngineInterface;

    class View implements ViewInterface
    {
        /**
         * @var string[]
         */
        private $dirs = [];

        /**
         * @var EngineInterface[]
         */
        private $engines = [];


        public function __construct(array $dirs, array $engines)
        {
            foreach ($dirs as $dir) {
                $this->dirs[] = $this->correctDirPath($dir);
            }

            $this->engines = $engines;
        }

        /**
         * @param string $views
         * @param array $args
         * @param null|string $content
         * @return null|string
         */
        public function render($views, array $args = [], $content = null)
        {
            if (!is_array($views)) {
                $views = [$views];
            }

            foreach ($views as $view) {
                $content = $this->renderView($view, $args, $content);
            }

            return $content;
        }

        /**
         * @param string $view
         * @param array $args
         * @param null|string $content
         * @return null|string
         */
        private function renderView($view, array &$args, $content = null)
        {
            foreach ($this->resolvePaths($view) as $path) {
                foreach ($this->engines as $suffix => $engine) {
                    $_path = $path . $suffix;

                    if (file_exists($_path)) {
                        $content = $engine->render($this, $_path, $args, $content);
                        break 2;
                    }
                }
            }

            return $content;
        }

        /**
         * @param $paths
         * @return array
         */
        private function resolvePaths($paths)
        {
            if (!is_array($paths)) {
                $paths = [$paths];
            }

            $resolved = [];
            foreach ($paths as $path) {
                $path = $this->correctViewPath($path);

                foreach ($this->dirs as $dir) {
                    $resolved[] = $dir . $path;
                }
            }

            return $resolved;
        }

        /**
         * @param string $path
         * @return string
         */
        private function correctDirPath($path)
        {
            return rtrim($path, '/');
        }

        /**
         * @param string $path
         * @return string
         */
        private function correctViewPath($path)
        {
            return '/' . trim($path, '/');
        }
    }
}