<?php

namespace Contest\PageBuilders;

interface PageBuilder {
    public function build($params = array());
}