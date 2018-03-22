<?php

namespace Ueef\Owlet\Engine {

    use Ueef\Owlet\Interfaces\ViewInterface;
    use Ueef\Owlet\Interfaces\EngineInterface;

    class Php implements EngineInterface
    {
        /**
         * @param ViewInterface $context
         * @param string $path
         * @param array $args
         * @param null|string $content
         * @return null|string
         */
        public function render(ViewInterface $context, $path, array &$args, $content = null)
        {
            $renderer = function () use ($path, $content, &$args) {
                extract($args, EXTR_OVERWRITE | EXTR_REFS);

                ob_start();
                require $path;
                return ob_get_clean();
            };

            $renderer = $renderer->bindTo($context, $context);

            return $renderer();
        }
    }
}
