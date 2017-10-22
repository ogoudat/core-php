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

use Ogoudat\Core\Character;
use PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNull()
    {
        $test = new Character(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithString()
    {
        $test = new Character('Ogöudat');
    }

    public function testCaseConversion()
    {
        $a = new Character('ö');
        $b = new Character('Ö');

        $this->assertEquals('Ö', (string) $a->toUpperCase());
        $this->assertEquals('ö', (string) $b->toLowerCase());
    }
}
