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

use IntlChar;
use InvalidArgumentException;

/**
 * The Character class represents a character.
 *
 * @author Peter Winnberg <hello@peterwinnberg.name>
 */
class Character
{
    protected $data;

    public function __construct($data)
    {
        if (is_null($data)) {
            throw new InvalidArgumentException('A Character cannot be null.');
        }

        if (!preg_match('//u', $data)) {
            throw new InvalidArgumentException('Not well formed UTF-8 data.');
        }

        if (1 !== mb_strlen($data, CharacterEncoding::UTF_8)) {
            throw new InvalidArgumentException('Character can only use strings with a length of 1.');
        }

        $this->data = $data;
    }

    /**
     * Get the Unicode code point for the Character.
     *
     * @return int
     */
    public function codePoint(): int
    {
        return IntlChar::ord($this->data);
    }

    /**
     * Compares this Character with another Character.
     *
     * @return bool
     */
    public function equals(Character $character): bool
    {
        return $this->data === $character->data;
    }

    /**
     * Get the Unicode name for the Character.
     *
     * @return string
     */
    public function name(): String
    {
        return IntlChar::charName($this->data);
    }

    /**
     * Converts the Character to lower case.
     *
     * @return \Ogoudat\Core\Character
     */
    public function toLowerCase(): Character
    {
        return new self(IntlChar::tolower($this->data));
    }

    /**
     * Converts the Character to upper case.
     *
     * @return \Ogoudat\Core\Character
     */
    public function toUpperCase(): Character
    {
        return new self(IntlChar::toupper($this->data));
    }

    public function __toString(): string
    {
        return $this->data;
    }
}
