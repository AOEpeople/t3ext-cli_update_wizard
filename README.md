t3ext-cli_update_wizard
=======================

This is a TYPO3 Extension that makes the migrations from the Upgrade Wizard in the Install Tool
executable from the command line. That way it can be used in automated builds.

It is only tested with TYPO3 6.2. Use at your own risk.

Cloning the repository
======================

Please remember that the extension folder in typo3conf/ext has to be called `cli_update_wizard`

    git clone https://github.com/czenker/t3ext-cli_update_wizard.git cli_update_wizard

HowTo
=====

The best way to use this tool is to run the update wizard once by hand to see
which migrations you actually need and want to execute. Afterwards you can use this
extension to automate that clicking for you.

To see a list of possible migrations

    php typo3/cli_dispatch.phpsh extbase migration:list

To execute a specific migration

    php typo3/cli_dispatch.phpsh extbase migration:perform sysext_file_rtemagicimages

This executes the migration called "sysext_file_rtemagicimages".
Exit status is 0 on success, 1 for failure.