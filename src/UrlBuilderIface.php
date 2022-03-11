<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

interface UrlBuilderIface
{
    function buildUrl( $container );
    static function init( $input_options );
}
