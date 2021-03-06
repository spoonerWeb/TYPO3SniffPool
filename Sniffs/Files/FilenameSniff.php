<?php
/**
 * TYPO3_Sniffs_Files_FilenameSniff.
 *
 * PHP version 5
 * TYPO3 version 4
 *
 * @category  PHP
 * @package   TYPO3_PHPCS_Pool
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2013 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
/**
 * DESCRIPTION
 *
 * @category  PHP
 * @package   TYPO3_PHPCS_Pool
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2013 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version   Release: @package_version@
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
class TYPO3SniffPool_Sniffs_Files_FilenameSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG);
    } //end register()

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $findTokens = array(
                       T_CLASS,
                       T_INTERFACE
                      );

        $stackPtr = $phpcsFile->findNext($findTokens, ($stackPtr + 1));

        // Check if we hit a file without a class. Raise a warning and return
        if (!$stackPtr) {
            $warning = 'Its recommended to use only PHP classes and avoid non-class files.';
            $phpcsFile->addWarning($warning, 1, 'Non-ClassFileFound');
            return;
        }
        $classNameToken = $phpcsFile->findNext(T_STRING, $stackPtr);
        $className      = $tokens[$classNameToken]['content'];
        $fullPath = basename($phpcsFile->getFileName());
        $fileName = substr($fullPath, 0, strrpos($fullPath, '.'));
        if ($fileName === '') {
            // No filename probably means STDIN, so we can't do this check.
            return;
        }

        // Use last part of class name for check if it's like Tx_Extension_XXX
        if (strpos($className, '_') > 0) {
            $classNameParts = explode('_', $className);
            $classNameForFileNameCheck = array_pop($classNameParts);
        } else {
            $classNameForFileNameCheck = $className;
        }
        if (strcmp($fileName, $classNameForFileNameCheck)) {
            $error = 'The classname is not equal to the filename; found "%s" as classname and "%s" for filename.';
            $data = array(
                        $classNameForFileNameCheck,
                        $fileName . '.php'
                    );
            $phpcsFile->addError($error, $stackPtr, 'ClassnameNotEqualToFilename', $data);
        }

        if (strtolower($fileName) === $fileName) {
            $error = 'The filename has to be in UpperCamelCase; found "%s".';
            $data = array(
                        $fileName . '.php'
                    );
            $phpcsFile->addError($error, $stackPtr, 'LowercaseFilename', $data);
        }

        if ($tokens[$stackPtr]['code'] === T_INTERFACE) {
            if (!stristr($fileName, 'Interface')) {
                $error = 'The file contains an interface but the string "Interface" is not part of the filename; found "%s", but expected "%s".';
                $data = array(
                            $fileName . '.php',
                            $className . '.php'
                        );
                $phpcsFile->addError($error, $stackPtr, 'InterfaceNotInFilename', $data);
            }
        }
    } //end process()
} //end class

?>
