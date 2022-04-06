<?php

namespace App\Helpers;

/**
 * Format response.
 */
class Helpers
{
    static public function generateExcerpt($title)
    {
        $new = wordwrap($title, 350);
        $new = explode("\n", $new);
    
        $new = $new[0] . '...';
    
        return $new;
    }
}