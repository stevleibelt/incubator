# Simple php crontab manager

## The Problem

I have multiple php applications with dedicated console commands triggered by one big crontab.
The crontab differes on multiple systems (production vs. container development).

## The Goal

For each php application, I want to be able to provide a template that can be maintained in the vcs.
Each template has variables to ease up adaptation on the current environment.
For shit hits the fan reason, I want to dump the whole crontab and disable it.

## The Solution

The CrontabManager class.

If you call the crontab_manager.php file, it will first run an "audit" based on the example crontab dump in the data path.
It will render the template and create an updated and new crontab.
If will print the differences.

After the audit, an update is done which is doing the same as audit except that it is not printing the differences.

## What Is Missing?

CrontabManager::deleteCronTab();
CrontabManager::disableSection();
CrontabManager::enableSection();

## Next Steps?

* add the missing methods mentioned in "What Is Missing".
* create a zend framework 3 module out of it with following command line calls
    * crontab-manager disable-crontab-section
    * crontab-manager disable-full-crontab
    * crontab-manager enable-crontab-section
    * crontab-manager enable-full-crontab
    * crontab-manager audit-section
    * crontab-manager update-section
