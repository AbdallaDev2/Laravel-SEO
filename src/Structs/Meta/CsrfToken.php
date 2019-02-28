<?php

namespace romanzipp\Seo\Structs\Meta;

use romanzipp\Seo\Structs\Meta;
use romanzipp\Seo\Structs\Struct;

class CsrfToken extends Meta
{
    protected $unique = true;

    public static function defaults(Struct $struct)
    {
        $struct->addAttribute('name', 'csrf-token');
    }

    public function token($token = null)
    {
        $this->addAttribute('content', $token);

        return $this;
    }
}
