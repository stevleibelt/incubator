# Generic Deployment To Do System

Free as in freedom and generic approach to cover handling of deployment to does in a generic way.

# Thoughts

* based on a vcs
    * support for multiple branches
    * based on recording and logging "latest commit id"
* independent from the environment (development, testing, staging or production system)
* each deployment to do list entry can be "automatically executed" or "outputed because of manual work (difficult to write a script for/external systems needed"

# Workflow

* use post-checkout and post-merge
* investigate current system status
    * read deployment to do list
    * read current branch name
    * read latest vcs commit id
    * read fitting (branch dependend) log
* compare deployment to does with steps in the local log
* output or execute deployment to do list entry
* commit each finished entry into the log
* save current git branch and latest commit
* remove local (branch dependend) log if branch is deleted via git ([post branch delete hook](http://stackoverflow.com/questions/14271989/git-branch-delete-hook#14285583)?)

# Scribbled Codes

## Log Entry

```
deployment_to_do_entry_uuid: <string>
vcs_branch_name: <string>
vcs_commit_id: <string>
created_at: <YYYY-mm-dd HH:ii:ss>
```

## Deployment To Do Entry

```
#as json
{
    "uuid": "<string>",
    "created_at": "<yyyy-mm-dd hh:ii:ss>",
    "created_by": "<name or unique identifier>",
    "list_of_affected_environments": {
        {
            "name": "development"
        },
        {
            "name": "production"
        },
        {
            "name": "staging"
        },
        {
            "name": "testing"
        }
    },
    "todo_task": {
        "description": "<string>",
        "is_executable": "<boolean>">,
        "relative_path_to_the_task": "<string>"
    },
    "undo_task": {
        "description": "<string>",
        "is_executable": "<boolean>">,
        "relative_path_to_the_task": "<string>"
    }
    "version": "<integer>"
}
```

# Unorderd Ideas

## Next Milestone

* environment dependend variables

## Nice To Have Or Just As Example

* configurable formatter to start using this side beside your current project until you have migrated your infrastructure
