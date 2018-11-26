<?php

namespace romanzipp\Seo\Structs;

use romanzipp\Seo\Enums\HookTarget;
use romanzipp\Seo\Structs\Traits\HookableTrait;

abstract class Struct
{
    use HookableTrait;

    abstract protected function tag(): string;

    /**
     * Can the website <head> contain more
     * than one element of this type.
     *
     * @var boolean
     */
    protected $unique = true;

    /**
     * Attribute names which should be unique across
     * all existing elements combined with the struct tag.
     *
     * @var array
     */
    protected $uniqueAttributes = [];

    /**
     * Attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Struct body
     *
     * @var null|string
     */
    protected $body = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        return static::defaults($this);
    }

    /**
     * Create struct instance.
     *
     * @return self
     */
    public static function make(): self
    {
        return new static;
    }

    /**
     * Modify struct after creation.
     *
     * @param self $struct
     */
    public static function defaults(self $struct)
    {
        //
    }

    /**
     * Get struct tag.
     *
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag();
    }

    /**
     * Get struct attributes.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Get computed attributes. Converts
     * objects to string values.
     *
     * @return array
     */
    public function getComputedAttributes(): array
    {
        $attributes = $this->attributes;

        array_walk($attributes, function (&$value, $attribute) {
            $value = (string) $value;
        });

        return $attributes;
    }

    /**
     * Get computed single attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function getComputedAttribute(string $attribute)
    {
        return $this->getComputedAttributes()[$attribute] ?? null;
    }

    /**
     * Get struct body.
     *
     * @return mixed|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Is struct unique.
     *
     * @return boolean
     */
    public function isUnique(): bool
    {
        return $this->unique;
    }

    /**
     * Get struct unique attributes for collision detection.
     *
     * @return array
     */
    public function getUniqueAttributes(): array
    {
        return $this->uniqueAttributes;
    }

    /**
     * Get all attributes with values that have been declared as unique.
     *
     * @return array
     */
    public function getComputedUniqueAttributes(): array
    {
        return array_filter($this->getAttributes(), function ($value, $key) {
            return in_array($key, $this->getUniqueAttributes());
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Fluid body setter.
     *
     * @param  mixed   $body
     * @param  boolean $escape Escape body
     * @return self
     */
    public function body($body, bool $escape = false): self
    {
        if ($escape) {
            $body = e($body);
        }

        $this->setBody($body);

        return $this;
    }

    /**
     * Fluid attributes setter.
     *
     * @param  string     $attribute
     * @param  mixed|null $value
     * @return self
     */
    public function attr(string $attribute, $value = null): self
    {
        $this->addAttribute($attribute, $value);

        return $this;
    }

    /**
     * Determines if struct is void element.
     *
     * @see  https://www.w3.org/TR/html/syntax.html#void-element
     *
     * @return boolean
     */
    public function isVoidElement(): bool
    {
        return in_array($this->getTag(), [
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
        ]);
    }

    /**
     * Set body.
     *
     * @param mixed $body
     */
    protected function setBody($body): void
    {
        $this->body = $body;

        $this->triggerHook(HookTarget::BODY, $this->body);
    }

    /**
     * Add attribute.
     *
     * @param string $key
     * @param mixed  $value
     */
    protected function addAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;

        $this->triggerHook(HookTarget::ATTRIBUTE, [$key => $this->attributes[$key]]);

        $this->triggerHook(HookTarget::ATTRIBUTES, $this->attributes);
    }
}
