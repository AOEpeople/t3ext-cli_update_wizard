<?php

namespace Xopn\CliUpdateWizard\Command;

use TYPO3\CMS\Extbase\Mvc\Controller\CommandController as ExtbaseCommandController;

/**
 * Helper methods
 */
abstract class CommandController extends ExtbaseCommandController {

	/**
	 * @param string $text
	 * @param array $arguments
	 */
	protected function outputBlock($text = '', array $arguments = array()) {
		if ($arguments !== array()) {
			$text = vsprintf($text, $arguments);
		}
		$this->outputLine(wordwrap($text, self::MAXIMUM_LINE_LENGTH, PHP_EOL));
	}

	protected function outputSeperator($seperator = '-') {
		$this->outputLine(str_repeat($seperator, self::MAXIMUM_LINE_LENGTH));
	}

} 