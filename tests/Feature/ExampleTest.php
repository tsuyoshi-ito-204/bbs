<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
	protected function setUp(): void
	{
		parent::setUp();
		echo __METHOD__;
	}
	
    public function testMethod1()
    {
		echo __METHOD__, PHP_EOL;
        $this->assertTrue(true);
    }
}
