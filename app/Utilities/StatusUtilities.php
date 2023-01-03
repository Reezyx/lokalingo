<?php

namespace App\Utilities;

class StatusUtilities
{
    const SUCCESS                       = "00";

    const USER_HAS_NOT_BEEN_VERIFIED    = "-1";
    const USER_BLOCK                    = "-2";

    const BAD_REQUEST                   = "-3";
    const TOKEN_EXPIRED                 = "-4";
    const TOKEN_INVALID                 = "-5";
    const TOKEN_BLACKLISTED             = "-6";
    const TOKEN_NOT_PROVIDED            = "-7";

    const CSRF_TOKEN_FAILED             = "-8";

    const FAILED                        = "-9";
    const FORBIDDEN                     = "-10";

    const USER_HAS_NOT_UPGRADE_ACCOUNT  = "-11";
}
