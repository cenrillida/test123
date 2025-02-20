<?php

namespace Crossref\PageBuilders;

interface PageBuilder {
    public function build($params = array());
}