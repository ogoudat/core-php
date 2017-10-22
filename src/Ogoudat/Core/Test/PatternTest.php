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

use Ogoudat\Core\Pattern;
use PHPUnit\Framework\TestCase;

class PatternTest extends TestCase
{
    public function testModifiers()
    {
        $pattern1 = new Pattern('/o/mi');
        $modifiers = $pattern1->getModifiers();

        $this->assertEquals(3, count($modifiers));
        $this->assertTrue(in_array('m', $modifiers));
        $this->assertTrue(in_array('i', $modifiers));
        $this->assertTrue(in_array('u', $modifiers));
    }
}
