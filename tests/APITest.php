<?php
//<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use Paolo\AssemblaAPI\API;

final class APITest extends TestCase
{
    public function testApiInstanceIsAPimpleContainer(): void
    {
        $this->assertInstanceOf(
            Container::class,
            (new API())->c()
        );
    }

    public function testContextHeadersAreDefined(): void
    {
        $api = new API([
            'X-Api-Key' => 'some-key',
            'X-Api-Secret' => 'secret'
            ]);

        $this->assertEquals( 'some-key', $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals( 'secret', $api->c()['context']['headers']['X-Api-Secret']);
    }

    public function testApiAuthCredsNotDefined(): void
    {
        $api = new API();

        $this->assertEquals($_ENV['ASSEMBLA_API_KEY'], $api->c()['context']['headers']['X-Api-Key']);
        $this->assertEquals($_ENV['ASSEMBLA_API_SECRET'], $api->c()['context']['headers']['X-Api-Secret']);
    }

    public function testBaseApiUrl(): void
    {
        $api = new API();
        $this->assertEquals('https://api.assembla.com/v1/spaces/PO-Migrations', $api->c()['getApiUrl']());
    }

    public function testOptionSubpath(): void
    {
        $api = new API(['subpath'=> 'tickets']);
        $this->assertEquals('https://api.assembla.com/v1/spaces/PO-Migrations/tickets', $api->c()['getApiUrl']());
    }

    public function testOptionSpace(): void
    {
        $api = new API(['space'=> 'cloudways-systeam']);
        $this->assertEquals('https://api.assembla.com/v1/spaces/cloudways-systeam', $api->c()['getApiUrl']());
    }

    public function xtestFetch(): void
    {

        # call phpunit with env as below
        # ASSEMBLA_API_KEY=someKey \
        # ASSEMBLA_API_SECRET=someSecret \
        # ASSEMBLA_SPACE=PO-Migrations \
        # phpunit ...
        $api = new API([
            'X-Api-Key' => getenv('ASSEMBLA_API_KEY'),
            'X-Api-Secret' =>  getenv('ASSEMBLA_API_SECRET'),
            'space' =>  getenv('ASSEMBLA_SPACE')
            ]);

        var_dump($api->fetch());
    }

}
