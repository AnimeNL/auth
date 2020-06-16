<?php

namespace App\Normalizer;

use App\Entity\Anplan\Scope as AnplanScope;
use Trikoder\Bundle\OAuth2Bundle\Model\Scope;

class ScopeNormalizer
{
    public static function normalize(AnplanScope $scope): Scope
    {
        return new Scope(str_replace(' ', '_', $scope));
    }
}
