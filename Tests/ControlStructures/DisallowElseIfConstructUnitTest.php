<?php
/**
 * Unit test class for the DisallowElseIfConstruct sniff.
 *
 * PHP version 5
 *
 * @category  ControlStructures
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2010 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
/**
 * Unit test class for the DisallowElseIfConstruct sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 *
 * @category  ControlStructures
 * @package   TYPO3SniffPool
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2010 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
class TYPO3SniffPool_Tests_ControlStructures_DisallowElseIfConstructUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList()
    {
        return array(4 => 1,);
    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return array();
    }
}
?>