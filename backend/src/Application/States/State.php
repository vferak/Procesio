<?php

namespace Procesio\Application\States;

class State
{
    public const STATUS_NEW = 'new';
    public const STATUS_INPROGRESS = 'in progress';
    public const STATUS_TODO = 'TODO';

    public static function getAllStates(): array
    {
        return [self::STATUS_NEW,self::STATUS_TODO,self::STATUS_INPROGRESS];
    }
}