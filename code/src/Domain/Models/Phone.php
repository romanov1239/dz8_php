<?php

namespace Geekbrains\Application1\Domain\Models;

class Phone
{
    public string $phone;

    public function __construct ()
    {
        $this->phone = '+7111111';
    }

    public function getPhone (): string
    {
        return $this->phone;
    }

}
