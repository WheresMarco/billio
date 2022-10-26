<?php

namespace Tests\Unit;

use App\Http\Controllers\CheckStudentController;
use Tests\TestCase;

class CheckStudentTest extends TestCase
{
    /**
     * Check valid NiN
     *
     * @return void
     */
    /** @test */
    public function checkValidNiN()
    {
        $checkStudent = new CheckStudentController;

        $this->assertEquals('lintek', $checkStudent->isStudentMember('9509232964'));
    }

    /**
     * Check not active NiN.
     *
     * @return void
     */
    /** @test */
    public function checkInactiveNiN()
    {
        $checkStudent = new CheckStudentController;

        $this->assertEquals('false', $checkStudent->isStudentMember('9403308662'));
    }

    /**
     * Check wrongly formatted valid NiN
     *
     * @return void
     */
    /** @test */
    public function checkWronglyFormattedNiN()
    {
        $checkStudent = new CheckStudentController;

        $this->assertEquals('lintek', $checkStudent->isStudentMember('19950923-2964'));
    }

    /**
     * Check invalid value.
     *
     * @return void
     */
    /** @test */
    public function checkInvalidNiN()
    {
        $checkStudent = new CheckStudentController;

        $this->assertFalse($checkStudent->isStudentMember('test'));
    }
}
