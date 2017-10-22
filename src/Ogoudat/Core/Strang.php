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

use Countable;
use InvalidArgumentException;
use Normalizer;

/**
 * The Strang class represents strings. Unlike regular PHP strings,
 * the focus is on the characters and not the bytes. Internally it uses UTF-8
 * and normalizes the string to Unicode Normalization Form C (NFC).
 *
 * Sträng is the Swedish word for string.
 *
 * @author Peter Winnberg <hello@peterwinnberg.name>
 */
class Strang implements Countable
{
    protected $data;

    public function __construct($data)
    {
        if (is_null($data)) {
            throw new InvalidArgumentException('A Strang cannot be null.');
        }

        if (!preg_match('//u', $data)) {
            throw new InvalidArgumentException('Not well formed UTF-8 data.');
        }

        if (!Normalizer::isNormalized($data, Normalizer::FORM_C)) {
            $data = Normalizer::normalize($data, Normalizer::FORM_C);
        }

        $this->data = $data;
    }

    /**
     * Get the number of bytes needed to store the Strang, after normalization
     * to NFC and conversion to a regular PHP string.
     */
    public function byteCount()
    {
        return strlen($this->data);
    }

    /**
     * Get an array with the characters in the Strang.
     *
     * @return array
     */
    public function characters(): array
    {
        $characters = preg_split('//u', $this->data, -1, PREG_SPLIT_NO_EMPTY);

        return array_map(function ($character) {
            return new Character($character);
        }, $characters);
    }

    /**
     * Alias for length(). Implements the Countable interface.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->length();
    }

    /**
     * Use Unicode Normalization Form D (NFD) to be able replace something in the
     * decomposed form. When the new Strang is created it is normalized back
     * to NFC.
     *
     * @return \Ogoudat\Core\Strang
     */
    protected function decomposeAndRemove(Pattern $pattern): Strang
    {
        $data = Normalizer::normalize($this->data, Normalizer::FORM_D);
        $data = preg_replace((string) $pattern, '', $data);

        return new self($data);
    }

    /**
     * Checks if the Strang is equal to another Strang.
     *
     * @param \Ogoudat\Core\Strang $strang the Strang you want to compare to this Strang
     *
     * @return bool
     */
    public function equals(Strang $strang): bool
    {
        return $this->data === $strang->data;
    }

    /**
     * Checks if the Strang is the empty string or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0 === $this->length();
    }

    /**
     * Get the number of characters in the Strang.
     *
     * @return int
     */
    public function length(): int
    {
        return mb_strlen($this->data, CharacterEncoding::UTF_8);
    }

    /**
     * Use Unicode Normalization Form D and remove all non-spacing marks
     * (everything matching \p{Mn}).
     *
     * @return \Ogoudat\Core\Strang
     */
    public function removeNonSpacingMarks(): Strang
    {
        return $this->decomposeAndRemove(new Pattern('/\p{Mn}/'));
    }

    /**
     * Splits a Strang using a Pattern.
     *
     * @return array
     */
    public function split(Pattern $pattern): array
    {
        return array_map(function ($piece) {
            return new self($piece);
        }, preg_split((string) $pattern, $this->data));
    }

    /**
     * Get a part of the Strang.
     *
     * @param int $start  Position where to start. The first character is position 0.
     * @param int $length Number of characters to get. Defaults to the string length if not specified.
     *
     * @return \Ogoudat\Core\Strang
     */
    public function subString(int $start, int $length = null): Strang
    {
        if (is_null($length)) {
            $length = $this->length();
        }

        return new self(mb_substr($this->data, $start, $length,
            CharacterEncoding::UTF_8));
    }

    /**
     * Converts the Strang to lower case.
     *
     * @return \Ogoudat\Core\Strang
     */
    public function toLowerCase(): Strang
    {
        return new self(mb_strtolower($this->data, CharacterEncoding::UTF_8));
    }

    /**
     * Converts the Strang to upper case.
     *
     * @return \Ogoudat\Core\Strang
     */
    public function toUpperCase(): Strang
    {
        return new self(mb_strtoupper($this->data, CharacterEncoding::UTF_8));
    }

    public function __toString(): string
    {
        return $this->data;
    }
}
