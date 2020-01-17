<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spam extends Model
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    public function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'yahoo customer supports'
        ];

        foreach ($invalidKeywords as  $keywords) {
            if (stripos($body, $keywords) !== false) {
                throw new \Exception('Your reply contain spam');
            }
        }
    }
}
