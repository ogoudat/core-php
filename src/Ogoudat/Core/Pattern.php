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
namespace Ogoudat\Core;

/**
 * The Pattern class represents a regular expression. It is responsible for
 * normalizing the pattern and adding needed modifiers like 'u'.
 *
 * @author Peter Winnberg <hello@peterwinnberg.name>
 */
class Pattern
{
    protected $pattern;
    protected $modifiers;

    public function __construct($pattern)
    {
        $this->pattern = new Strang($pattern);
        $this->modifiers = [];

        if (preg_match('/\/([a-zA-Z]*)$/', $pattern, $modifiers)) {
            $modifiers = preg_split('//u', $modifiers[1], -1, PREG_SPLIT_NO_EMPTY);

            for ($i = 0; $i < count($modifiers); $i++) {
                $this->modifiers[$modifiers[$i]] = true;
            }
        }

        $this->modifiers['u'] = true;
    }

    public function getModifiers()
    {
        return array_keys($this->modifiers);
    }

    public function __toString(): string
    {
        return $this->pattern . join('', array_keys($this->modifiers));
    }
}
