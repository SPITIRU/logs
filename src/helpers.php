<?php

use ArtemiyKudin\log\Logger;

if (! function_exists('activity')) {
    function activity()
    {
        return app(Logger::class);
    }
}
