<?php
//<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Paolo\AssemblaAPI\Space as API;
use Paolo\AssemblaAPI\BaseAPI;

final class SpaceTest extends TestCase
{

    /**
     * @group unit
     */
    public function testApiInstanceIsAPimpleContainer(): void
    {
        $this->assertInstanceOf( BaseAPI::class, API::init() );
    }

    /**
     * @group unit
     */
    public function testContextHeadersAreDefined(): void
    {
        $api = API::init([
            'ASSEMBLA_KEY' => 'some-key',
            'ASSEMBLA_SECRET' => 'secret'
            ]);

        $this->assertEquals( 'some-key', $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals( 'secret', $api->c()['context']['headers']['X-Api-Secret']);
    }

    /**
     * @group extra
     */
    public function testApiAuthCredsNotDefined(): void
    {
        $api = API::init();
        $this->assertEquals($_ENV['ASSEMBLA_KEY'], $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals($_ENV['ASSEMBLA_SECRET'], $api->c()['context']['headers']['X-Api-Secret']);
    }

    /**
     * @group unit
     */
    public function testBaseApiUrl(): void
    {
        $api = API::init();
        $this->assertEquals('https://api.assembla.com/v1/spaces/PO-Migrations', $api->c()['getApiUrl']());
    }

    /**
     * @group feature
     */
    public function testOptionSpace(): void
    {
        $api = API::init(['ASSEMBLA_SPACE'=> 'cloudways-systeam']);
        $this->assertEquals('https://api.assembla.com/v1/spaces/cloudways-systeam', $api->c()['getApiUrl']());
    }

    /**
     * @group feature
     */
    public function testFetch(): void
    {

        # call phpunit with env as below
        /*
        ASSEMBLA_KEY=someKey \
        ASSEMBLA_SECRET=someSecret \
        ASSEMBLA_SPACE=PO-Migrations \
        p --group feature ...
        */
        $api = API::init([
            'ASSEMBLA_KEY' => getenv('ASSEMBLA_KEY'),
            'ASSEMBLA_SECRET' =>  getenv('ASSEMBLA_SECRET'),
            'ASSEMBLA_SPACE' =>  getenv('ASSEMBLA_SPACE')
            ]);

        var_dump($api->fetch());
    }

}
