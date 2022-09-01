<?php

namespace Kangangga\Starsender\Mixin;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Message extends Stringable
{
    public $body;
    public $header;
    public $footer;

    public const NONE = "";
    public const BOLD = "*";
    public const ITALIC = "_";
    public const MONOSPACE = "```";
    public const STRIKETHROUGH = "~";

    public function setHeader($value, $format = self::BOLD)
    {
        $this->header = $this
            ->before($this->value())
            ->newLine(1)
            ->append($format)
            ->append($value)
            ->append($format)
            ->newLine(3);

        return $this->header;
    }

    /**
     * setBody function
     *
     * @param string $value
     * @param \Closure|null $concrete
     * @return $this
     */
    public function setBody($value, $concrete = null)
    {
        $this->body = $this->append($value);

        if ($concrete instanceof \Closure) {
            $concrete($this->body);
        }

        return $this->body;
    }

    public function setFooter($value, $format = self::BOLD)
    {
        $this->footer = $this
            ->newLine(3)
            ->append($format)
            ->append($value)
            ->append($format)
            ->newLine(2);

        return $this->footer;
    }

    public function text($value)
    {
        return $this->append($value)->newLine();
    }

    public function separator($count = 58)
    {
        return $this
            ->append(str_repeat('-', $count))
            ->newLine();
    }

    public function urlencode()
    {
        return urlencode($this->toString());
    }
}
