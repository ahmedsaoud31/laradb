<?php

namespace AhmedSaoud31\Laradb\Tests\Feature;

use AhmedSaoud31\Laradb\Tests\TestCase;

class LaradbCommandTest extends TestCase
{
    /** @test */
    public function it_executes_the_Laradb_status_command()
    {
        $this->artisan('Laradb:status')
            ->expectsOutput('Laradb console package is working properly!')
            ->assertExitCode(0);
    }
}
