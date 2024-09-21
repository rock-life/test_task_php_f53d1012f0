<?php

namespace App\Enums;

enum TaskStatuses: int
{
    case Pending = 0;
    case InProgress = 1;
    case Completed = 2;

}
