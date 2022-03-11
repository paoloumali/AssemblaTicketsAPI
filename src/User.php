<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

class User extends BaseAPI implements UrlBuilderIface
{
    public function buildUrl($container) {
        return $container['base_url'].'/users';
    }

    public static function init( $input_options = [
        'X-Api-Key' => null,
        'X-Api-Secret' => null,
        'space' => 'PO-Migrations'
    ]) {
        return new static($input_options);
    }
}
