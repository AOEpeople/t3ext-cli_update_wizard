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