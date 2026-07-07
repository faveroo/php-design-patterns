<?php

namespace Patterns\Prototype\Models;

use Patterns\Prototype\Prototypes\Page;

class Author
{
    private $name;

    /**
     * @var Page[]
     */
    private $pages = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    } 

    public function addToPage(Page $page): void
    {
        $this->pages[] = $page;
    }
}