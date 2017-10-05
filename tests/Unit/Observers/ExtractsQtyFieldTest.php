<?php

namespace Tests\Unit\Observers;

use App\Observers\ExtractsQtyField;
use Tests\TestCase;

class ExtractsQtyFieldTest extends TestCase
{
    /** @test */
    public function it_checks_whether_description_has_a_numeric()
    {
        $this->assertTrue(ExtractsQtyField::hasNumeric('12 squishies'));
        $this->assertFalse(ExtractsQtyField::hasNumeric('squishies'));
        $this->assertFalse(ExtractsQtyField::hasNumeric('squis 12 hies'));
    }

    /** @test */
    public function it_gets_numeric_from_description()
    {
        $this->assertEquals(1, ExtractsQtyField::getNumeric('1 squish'));
        $this->assertEquals(12, ExtractsQtyField::getNumeric('12 squishies'));
    }

    /** @test */
    public function it_gets_new_description()
    {
        $this->assertEquals('squishies', ExtractsQtyField::getDescription('12 squishies'));
    }
}
