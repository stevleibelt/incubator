# Secure /etc with git

## Setup

```
cd /etc
git init main
git add .
git commit -m "initial commit"
```

## As systemd timer executed each X hours/days

```
CURRENT_BRANCH=$(date +'%Y%m'

#check if brach ${CURRENT_BRANCH} exists or create it
#check if we are in ${CURRENT_BRANCH} or switch into it
#check if something has changed
#if so
git add .
git commit -m "Commited change"
#check if there is a previous branch (last month)
#switch to main
#merge previous branch into it with `git merge --squash -m "merged branch"
```
