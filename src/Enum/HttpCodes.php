<?php

namespace App\Enum;

/**
 *
 */
enum HttpCodes: int
{
    case USER_NOT_FOUND = 462;
    case INVALID_PASSWORD = 463;
    case INVALID_TOKEN = 464;
    case TOKEN_EXPIRED = 465;
    case PASSWORD_DO_NOT_MATCH = 466;
    case PASSWORD_TOO_WEAK = 467;
}
