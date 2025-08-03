<?php

namespace App;

enum NotFound: string
{
    case TASK_NOT_FOUND = 'Task not found';
    case STATUS_NOT_FOUND = 'Status not found';
}
