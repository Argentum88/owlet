<?php

namespace Ueef\Owlet\Interfaces {

    interface ViewInterface
    {
        /**
         * @param string $views
         * @param array $args
         * @param string|null $content
         * @return null|string
         */
        public function render($views, array $args, $content = null);
    }
}
