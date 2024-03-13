<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Domain\Models\User;

class AbstractController
{
    protected array $actionsPermissions = [];

    public function getUserRoles (): array
    {
        $user = new User();
        return $user -> getUserRoles ();
    }

    public function getActionsPermissions (string $methodName): array
    {
        return isset($this -> actionsPermissions[$methodName]) ? $this -> actionsPermissions[$methodName] : [];
    }
}