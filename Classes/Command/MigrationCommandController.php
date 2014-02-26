<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Christian Zenker
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Xopn\CliUpdateWizard\Command;

use TYPO3\CMS\Install\Status\ErrorStatus;
use TYPO3\CMS\Install\Status\OkStatus;

class MigrationCommandController extends CommandController {

	/**
	 * @var \Xopn\CliUpdateWizard\Service\UpdateToolService
	 * @inject
	 */
	protected $updateToolService;

	/**
	 * show all available migrations
	 */
	public function listCommand() {
		$updates = $this->updateToolService->getAvailableUpdates();
		if(empty($updates)) {
			$this->outputLine('No updates available.');
		} else {
			foreach($updates as $update) {
				$this->outputLine('');
				$this->outputLine($update['identifier']);
				$this->outputSeperator();
				$this->outputLine('');
				$this->outputBlock($update['title']);
				$this->outputLine('');
				$this->outputBlock($update['explanation']);
			}
		}
	}

	/**
	 * perform the specified migration
	 *
	 * @param string $identifier
	 * @param string $userInput
	 * @throws \RuntimeException
	 */
	public function performCommand($identifier, $userInput = NULL) {
		if($this->doesUpdateNeedToBePerformed($identifier)) {
			$result = $this->updateToolService->performUpdate($identifier, $userInput);

			if($result instanceof OkStatus) {
				$this->outputLine($result->getTitle());
			} elseif($result instanceof ErrorStatus) {
				$this->outputLine($result->getTitle());
				$this->sendAndExit(1);
			} else {
				throw new \RuntimeException(sprintf(
					'Unexpected return of class %s.', get_class($result)
				));
			}
		} else {
			$this->outputLine(sprintf('The update "%s" does not need to be performed. Skipping.', $identifier));
		}
	}

	/**
	 * returns TRUE if an update has to be performed
	 *
	 * @param $identifier
	 * @return boolean
	 */
	protected function doesUpdateNeedToBePerformed($identifier) {
		foreach($this->updateToolService->getAvailableUpdates() as $update) {
			if($update['identifier'] === $identifier) {
				return TRUE;
			}
		}
		return FALSE;
	}
}