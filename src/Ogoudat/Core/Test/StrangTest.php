<?php

declare(strict_types=1);

/*
* This file is part of Ogöudat's core PHP library.
*
* (c) Peter Winnberg <hello@peterwinnberg.name>
*
* For more information about copying and licensing, please see the LICENSE.md
* file that was included with this source code.
*/
namespace Ogoudat\Core\Test;

use Normalizer;
use Ogoudat\Core\Character;
use Ogoudat\Core\Pattern;
use Ogoudat\Core\Strang;
use PHPUnit\Framework\TestCase;

class StrangTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNull()
    {
        $test = new Strang(null);
    }

    public function testCaseConversion()
    {
        $test = new Strang('Ogöudat');

        $this->assertEquals('OGÖUDAT', (string) $test->toUpperCase());
        $this->assertEquals('ogöudat', (string) $test->toLowerCase());
    }

    public function testEquals()
    {
        $strang1 = new Strang(Normalizer::normalize('åäö', Normalizer::FORM_C));
        $strang2 = new Strang(Normalizer::normalize('åäö', Normalizer::FORM_D));

        $this->assertTrue($strang1->equals($strang2));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUnicodeData()
    {
        $test = new Strang(substr('Ogöudat', 0, 3));
    }

    public function testLength()
    {
        $test = new Strang('');

        $this->assertTrue($test->isEmpty());
        $this->assertEquals(0, $test->byteCount());
        $this->assertEquals(0, $test->length());
        $this->assertEquals(0, $test->count());
        $this->assertEquals(0, count($test));
        $this->assertEquals(0, count($test->characters()));

        $test2 = new Strang('Ogöudat');

        $this->assertFalse($test2->isEmpty());
        $this->assertEquals(8, $test2->byteCount());
        $this->assertEquals(7, $test2->length());
        $this->assertEquals(7, $test2->count());
        $this->assertEquals(7, count($test2));
        $this->assertEquals(7, count($test2->characters()));
    }

    public function testSubString()
    {
        $test = new Strang('Ogöudat');

        $this->assertEquals('Ogöu', (string) $test->subString(0, 4));
        $this->assertEquals('dat', (string) $test->subString(4, 3));
        $this->assertEquals('dat', (string) $test->subString(4));
    }

    public function testRemoveNonSpacingMarks()
    {
        $test = new Strang('Ogöudat');

        $this->assertEquals('Ogoudat',
            (string) $test->removeNonSpacingMarks());
    }

    public function testSplit()
    {
        $assembledData = new Strang('Ogöudat');
        $pieces = $assembledData->split(new Pattern('/[ö]/'));

        $this->assertEquals(2, count($pieces));
        $this->assertTrue($pieces[0]->equals(new Strang('Og')));
        $this->assertTrue($pieces[1]->equals(new Strang('udat')));
    }

    public function testCharacters()
    {
        $characters = (new Strang('åäö'))->characters();

        $this->assertTrue((new Character('å'))->equals($characters[0]));
        $this->assertTrue((new Character('ä'))->equals($characters[1]));
        $this->assertTrue((new Character('ö'))->equals($characters[2]));
    }
}
