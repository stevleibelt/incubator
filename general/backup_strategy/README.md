# Generic Backup Strategy for Home Use

Major issue is how to solve the problem to backup data from a pc (with less storage) to the backup server (with more storage) especially if you have multiple sources (multiple pc's, shared directory by multipe users etc.)

# Unorderd thoughts

* possible solution
    * use nextcloud and select only the things you want to sync on each client
* possible solution
    * separate between current and archived data
    * current data can be changed (r/w)
    * archived data can ne read only
    * use softlinks to point to archived data
    * rsync -a --safe-links <source>/ <destination> (add --delete if you want to be the single point of truth)

# Benefit

* readable access to old data
* you can link to the archive
* you are not syncing the archive (because of --safe-links)
* you can be the single point of truth (not shared files)

# Example

```
cd $HOME
mkdir .archive document
cd document
mkdir financial
cd financial
mkdir current_year
ln -s ${HOME}/.archive/document/financial/2015 2015
```
# To Do

* create script make a backup
* create a script to restore the backup
* create a script to generate the make a backup script
* automate backup and archiving of directories that are created by the year
* add support for zfs snapshot capability
