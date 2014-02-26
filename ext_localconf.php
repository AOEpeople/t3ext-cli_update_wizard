<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

if (TYPO3_MODE === 'BE') {
	// Register commands
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Xopn\\CliUpdateWizard\\Command\\MigrationCommandController';
}
