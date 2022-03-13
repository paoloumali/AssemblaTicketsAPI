<?php declare(strict_types=1);

namespace Paolo\AssemblaAPI;

class Ticket extends BaseAPI implements UrlBuilderIface
{
    public function buildUrl($c) {

        if ( !isset($c['options']['ASSEMBLA_MILESTONE']) )
            throw new \Exception('Milestone should be defined.');

        return $c['base_url'].'/tickets/milestone/'.$c['options']['ASSEMBLA_MILESTONE'];
    }

    public static function init( $input_options = [
        'ASSEMBLA_KEY' => null,
        'ASSEMBLA_SECRET' => null,
        'ASSEMBLA_SPACE' => 'PO-Migrations',
        'ASSEMBLA_MILESTONE' => null
    ]) {
        return new static($input_options);
    }
}
