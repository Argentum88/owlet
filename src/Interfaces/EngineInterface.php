<?php

namespace Ueef\Owlet\Interfaces {

    interface EngineInterface
    {
        /**
         * @param ViewInterface $context
         * @param string $path
         * @param array $args
         * @param null|string $content
         * @return null|string
         */
        public function render(ViewInterface $context, $path, array &$args, $content = null);
    }
}
