<?php

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