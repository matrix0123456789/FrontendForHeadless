<?php

namespace Common;

class PageStandardController extends \Core\StandardController
{
    use \CommonBase\PageStandardControllerTrait;

    protected $headLinks = [['rel' => 'search', 'type' => 'application/opensearchdescription+xml', 'href' => '/Search/openSearchDescription', 'title' => 'Kancelaria Wierzytelności']];

    public function getPageTitle(): string
    {
        return "Demo";
    }

    public function getPageHeader()
    {
        return ['title' => 'Demo'];
    }
}

