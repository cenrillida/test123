<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2014 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Style;

/**
 * Numbering level definition
 *
 * @link http://www.schemacentral.com/sc/ooxml/e-w_lvl-1.html
 * @since 0.10.0
 */
class NumberingLevel extends AbstractStyle
{
    /**
     * Level number, 0 to 8 (total 9 levels)
     *
     * @var integer
     */
    private $level = 0;

    /**
     * Starting value w:start
     *
     * @var integer
     * @link http://www.schemacentral.com/sc/ooxml/e-w_start-1.html
     */
    private $start = 1;

    /**
     * Numbering format bullet|decimal|upperRoman|lowerRoman|upperLetter|lowerLetter
     *
     * @var string
     * @link http://www.schemacentral.com/sc/ooxml/t-w_ST_NumberFormat.html
     */
    private $format;

    /**
     * Restart numbering level symbol w:lvlRestart
     *
     * @var integer
     * @link http://www.schemacentral.com/sc/ooxml/e-w_lvlRestart-1.html
     */
    private $restart;

    /**
     * Related paragraph style
     *
     * @var string
     * @link http://www.schemacentral.com/sc/ooxml/e-w_pStyle-2.html
     */
    private $pStyle;

    /**
     * Content between numbering symbol and paragraph text
     *
     * @var string tab|space|nothing
     * @link http://www.schemacentral.com/sc/ooxml/e-w_suff-1.html
     */
    private $suffix = 'tab';

    /**
     * Numbering level text e.g. %1 for nonbullet or bullet character
     *
     * @var string
     * @link http://www.schemacentral.com/sc/ooxml/e-w_lvlText-1.html
     */
    private $text;

    /**
     * Align left|center|right|both
     *
     * @var string
     * @link http://www.schemacentral.com/sc/ooxml/e-w_lvlJc-1.html
     */
    private $align;

    /**
     * Left
     *
     * @var integer
     */
    private $left;

    /**
     * Hanging
     *
     * @var integer
     */
    private $hanging;

    /**
     * Tab position
     *
     * @var integer
     */
    private $tabPos;

    /**
     * Font family
     *
     * @var string
     */
    private $font;

    /**
     * Hint default|eastAsia|cs
     *
     * @var string
     * @link http://www.schemacentral.com/sc/ooxml/a-w_hint-1.html
     */
    private $hint;

    private $fontSize;

    /**
     * @return mixed
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * @param mixed $fontSize
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param integer $value
     * @return self
     */
    public function setLevel($value)
    {
        $this->level = $this->setIntVal($value, $this->level);
        return $this;
    }

    /**
     * Get start
     *
     * @return integer
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set start
     *
     * @param integer $value
     * @return self
     */
    public function setStart($value)
    {
        $this->start = $this->setIntVal($value, $this->start);
        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set format
     *
     * @param string $value
     * @return self
     */
    public function setFormat($value)
    {
        $enum = array('bullet', 'decimal', 'upperRoman', 'lowerRoman', 'upperLetter', 'lowerLetter');
        $this->format = $this->setEnumVal($value, $enum, $this->format);
        return $this;
    }

    /**
     * Get start
     *
     * @return integer
     */
    public function getRestart()
    {
        return $this->restart;
    }

    /**
     * Set start
     *
     * @param integer $value
     * @return self
     */
    public function setRestart($value)
    {
        $this->restart = $this->setIntVal($value, $this->restart);
        return $this;
    }

    /**
     * Get related paragraph style
     *
     * @return string
     */
    public function getPStyle()
    {
        return $this->pStyle;
    }

    /**
     * Set  related paragraph style
     *
     * @param string $value
     * @return self
     */
    public function setPStyle($value)
    {
        $this->pStyle = $value;
        return $this;
    }

    /**
     * Get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set suffix
     *
     * @param string $value
     * @return self
     */
    public function setSuffix($value)
    {
        $enum = array('tab', 'space', 'nothing');
        $this->suffix = $this->setEnumVal($value, $enum, $this->suffix);
        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text
     *
     * @param string $value
     * @return self
     */
    public function setText($value)
    {
        $this->text = $value;
        return $this;
    }

    /**
     * Get align
     *
     * @return string
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * Set align
     *
     * @param string $value
     * @return self
     */
    public function setAlign($value)
    {
        $enum = array('left', 'center', 'right', 'both');
        $this->align = $this->setEnumVal($value, $enum, $this->align);
        return $this;
    }

    /**
     * Get left
     *
     * @return integer
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set left
     *
     * @param integer $value
     * @return self
     */
    public function setLeft($value)
    {
        $this->left = $this->setIntVal($value, $this->left);
        return $this;
    }

    /**
     * Get hanging
     *
     * @return integer
     */
    public function getHanging()
    {
        return $this->hanging;
    }

    /**
     * Set hanging
     *
     * @param integer $value
     * @return self
     */
    public function setHanging($value)
    {
        $this->hanging = $this->setIntVal($value, $this->hanging);
        return $this;
    }

    /**
     * Get tab
     *
     * @return integer
     */
    public function getTabPos()
    {
        return $this->tabPos;
    }

    /**
     * Set tab
     *
     * @param integer $value
     * @return self
     */
    public function setTabPos($value)
    {
        $this->tabPos = $this->setIntVal($value, $this->tabPos);
        return $this;
    }

    /**
     * Get font
     *
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set font
     *
     * @param string $value
     * @return self
     */
    public function setFont($value)
    {
        $this->font = $value;
        return $this;
    }

    /**
     * Get hint
     *
     * @return string
     */
    public function getHint()
    {
        return $this->hint;
    }

    /**
     * Set hint
     *
     * @param string $value
     * @return self
     */
    public function setHint($value = null)
    {
        $enum = array('default', 'eastAsia', 'cs');
        $this->hint = $this->setEnumVal($value, $enum, $this->hint);

        return $this;
    }
}
