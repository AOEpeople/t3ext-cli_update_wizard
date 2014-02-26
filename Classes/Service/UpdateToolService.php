<?php

namespace Xopn\CliUpdateWizard\Service;

use TYPO3\CMS\Install\Controller\Action\Tool\UpdateWizard;

/**
 * Adapter to have Service like interface for TYPO3\CMS\Install\Controller\Action\Tool\UpdateWizard
 *
 * @see TYPO3\CMS\Install\Controller\Action\Tool\UpdateWizard
 */
class UpdateToolService extends UpdateWizard {

	/**
	 * @var \Xopn\CliUpdateWizard\View\DummyView
	 * @inject
	 */
	protected $view = NULL;

	/**
	 * @param $identifier
	 * @param $userInput
	 * @throws \InvalidArgumentException
	 * @return \TYPO3\CMS\Install\Status\StatusInterface
	 */
	public function performUpdate($identifier, $userInput = NULL) {
		$this->postValues['values']['identifier'] = $identifier;
		$this->postValues['values'][$identifier] = $userInput;

		if(!array_key_exists($identifier, $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'])) {
			throw new \InvalidArgumentException(sprintf(
				'"%s" is no valid identifier for a migration'
			));
		}

		return parent::performUpdate();
	}

	/**
	 * get an array of all possible updates that have not yet been executed
	 * @return array
	 */
	public function getAvailableUpdates() {
		parent::listUpdates();

		return $this->view->get('availableUpdates');
	}


} 