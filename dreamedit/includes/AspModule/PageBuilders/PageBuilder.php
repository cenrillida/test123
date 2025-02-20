<?php

namespace AspModule\PageBuilders;

interface PageBuilder {
    public function build($params = array());
}