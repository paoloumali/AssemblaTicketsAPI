<?php
//<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Paolo\AssemblaAPI\BaseAPI as API;

final class BaseAPITest extends TestCase
{
    /**
     * @group unit
     */
    public function testApiInstanceIsAPimpleContainer(): void
    {
        $this->assertInstanceOf( Container::class, API::init() );
    }

    /**
     * @group unit
     */
    public function testContextHeadersAreDefined(): void
    {
        $api = API::init([
            'X-Api-Key' => 'some-key',
            'X-Api-Secret' => 'secret'
            ]);

        $this->assertEquals( 'some-key', $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals( 'secret', $api->c()['context']['headers']['X-Api-Secret']);
    }

    /**
     * @group unit
     */
    public function testApiAuthCredsNotDefined(): void
    {
        $api = API::init();
        $this->assertEquals($_ENV['ASSEMBLA_API_KEY'], $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals($_ENV['ASSEMBLA_API_SECRET'], $api->c()['context']['headers']['X-Api-Secret']);
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
     * @group unit
     */
    public function testOptionSubpath(): void
    {
        $api = API::init(['subpath'=> 'tickets']);
        $this->assertEquals('https://api.assembla.com/v1/spaces/PO-Migrations/tickets', $api->c()['getApiUrl']());
    }

    /**
     * @group unit
     */
    public function testOptionSpace(): void
    {
        $api = API::init(['space'=> 'cloudways-systeam']);
        $this->assertEquals('https://api.assembla.com/v1/spaces/cloudways-systeam', $api->c()['getApiUrl']());
    }

    /**
     * @group feature
     */
    public function testFetch(): void
    {

        # call phpunit with env as below
        /*
        ASSEMBLA_API_KEY=someKey \
        ASSEMBLA_API_SECRET=someSecret \
        ASSEMBLA_SPACE=PO-Migrations \
        p --group feature ...
        */
        $api = new API([
            'X-Api-Key' => getenv('ASSEMBLA_API_KEY'),
            'X-Api-Secret' =>  getenv('ASSEMBLA_API_SECRET'),
            'space' =>  getenv('ASSEMBLA_SPACE')
            ]);

        var_dump($api->fetch());
    }

}
