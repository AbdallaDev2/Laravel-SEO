<?php

namespace romanzipp\Seo\Services\Traits;

use romanzipp\Seo\Structs\Meta;
use romanzipp\Seo\Structs\Meta\Description;
use romanzipp\Seo\Structs\Meta\OpenGraph;
use romanzipp\Seo\Structs\Meta\Twitter;
use romanzipp\Seo\Structs\Struct;
use romanzipp\Seo\Structs\Title;

trait ShorthandSetterTrait
{
    /**
     * Add title.
     *
     * @param  string|null $title
     * @return self
     */
    public function title(string $title = null): self
    {
        return $this->add(
            Title::make()->body($title)
        );
    }

    /**
     * Add description.
     *
     * @param  string|null $description
     * @return self
     */
    public function description(string $description = null): self
    {
        return $this->add(
            Description::make()->name('description')->content($description)
        );
    }

    /**
     * Add Twitter struct.
     *
     * @param  string     $name
     * @param  mixed|null $content
     * @return self
     */
    public function twitter(string $name, $content = null): self
    {
        return $this->add(
            Twitter::make()->name($name)->content($content)
        );
    }

    /**
     * Add OpenGraph struct.
     *
     * @param  string     $property
     * @param  mixed|null $content
     * @return self
     */
    public function og(string $property, $content = null): self
    {
        return $this->add(
            OpenGraph::make()->property($property)->content($content)
        );
    }
}