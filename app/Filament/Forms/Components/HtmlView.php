<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class HtmlView extends Field
{
    protected string $view = 'filament.forms.components.html-view';

    protected string | \Closure | null $html = null;

    public static function make(?string $name = null): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function html(string | \Closure | null $html): static
    {
        $this->html = $html;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->evaluate($this->html);
    }
}

