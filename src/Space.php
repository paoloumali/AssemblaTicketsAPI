<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

class Space extends BaseAPI implements UrlBuilderIface
{
    public function buildUrl($c) {
        return $c['base_url'];
    }

    public static function init( $input_options = [
        'ASSEMBLA_KEY' => null,
        'ASSEMBLA_SECRET' => null,
        'ASSEMBLA_SPACE' => 'PO-Migrations'
    ]) {
        return new static($input_options);
    }
}
