<?php

declare(strict_types=1);

namespace Procesio\Application\Settings;

interface SettingsInterface
{
    public function get(string $key = ''): mixed;
}
