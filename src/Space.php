<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

class Space extends BaseAPI implements UrlBuilderIface
{
    public function buildUrl($c) {
        return $c['base_url'];
    }

    public static function init( $input_options = [
        'X-Api-Key' => null,
        'X-Api-Secret' => null,
        'space' => 'PO-Migrations'
    ]) {
        return new static($input_options);
    }
}
