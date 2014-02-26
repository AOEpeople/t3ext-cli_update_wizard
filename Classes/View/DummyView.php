<?php

namespace Xopn\CliUpdateWizard\View;

use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

/**
 * a view that only stores assigned values, but does not render anything.
 *
 * It is used as a mock for the UpdateToolService
 * @see \Xopn\CliUpdateWizard\Service\UpdateToolService
 */
class DummyView implements ViewInterface {

	/**
	 * @var array
	 */
	protected $values = array();

	/**
	 * Sets the current controller context
	 *
	 * @param \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext
	 * @return void
	 */
	public function setControllerContext(\TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext) { /* NO-OP */ }

	/**
	 * Add a variable to the view data collection.
	 * Can be chained, so $this->view->assign(..., ...)->assign(..., ...); is possible
	 *
	 * @param string $key Key of variable
	 * @param mixed $value Value of object
	 * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assign($key, $value) {
		$this->values[$key] = $value;
		return $this;
	}

	/**
	 * Add multiple variables to the view data collection
	 *
	 * @param array $values array in the format array(key1 => value1, key2 => value2)
	 * @return \TYPO3\CMS\Extbase\Mvc\View\ViewInterface an instance of $this, to enable chaining
	 * @api
	 */
	public function assignMultiple(array $values) {
		foreach($values as $key=>$value) {
			$this->assign($key, $value);
		}
		return $this;
	}

	/**
	 * Tells if the view implementation can render the view for the given context.
	 *
	 * @param \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext
	 * @return boolean TRUE if the view has something useful to display, otherwise FALSE
	 * @api
	 */
	public function canRender(\TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext) {
		return TRUE;
	}

	/**
	 * Renders the view
	 *
	 * @return string The rendered view
	 * @api
	 */
	public function render() {
		return '';
	}

	/**
	 * Initializes this view.
	 *
	 * @return void
	 * @api
	 */
	public function initializeView() { /* NO-OP */ }

	/**
	 * get an assigned value
	 *
	 * @param $key
	 * @throws \InvalidArgumentException
	 * @return
	 */
	public function get($key) {
		if(!array_key_exists($key, $this->values)) {
			throw new \InvalidArgumentException(sprintf('value "%s" is not set', $key));
		}

		return $this->values[$key];
	}
}