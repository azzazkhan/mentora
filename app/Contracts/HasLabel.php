<?php

namespace App\Contracts;

interface HasLabel
{
    /**
     * Get the label for the value.
     *
     * @return string|null
     */
    public function getLabel(): ?string;
}
