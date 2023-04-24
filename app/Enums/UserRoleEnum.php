<?php
namespace App\Enums;


enum UserRoleEnum:string
{
    case WORKER = 'worker';
    case CLIENT = 'client';
}