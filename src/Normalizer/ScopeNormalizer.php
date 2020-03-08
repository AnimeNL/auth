<?php

namespace App\Normalizer;

use Trikoder\Bundle\OAuth2Bundle\Model\Scope;

class ScopeNormalizer
{
    public static function normalize(Scope $scope): Scope
    {
        return new Scope(str_replace(' ', '_', $scope));
    }
}
