# Release Creation Helper

This package provides console commands to easy up creation of a release from a git repository.

# Assumption

This code is based on some assumptions.
First of all, you are working with git as version control system.
Furthermore, you are having a lot of branches. Maybe you are using git flow, or simple create a branch per defect/story (to talk in scrum terms).
Also it is assumed that each branch has a unique identifier like a ticket or a task number.

# Usage

## Find All The Branches You Want To Merge

```
#assumed you want to find the branches with unique identifiers:
#   S-1234 S-0815 S-23 S-42
./bin/net_bazzline_find_origin_branch_name S-1234 S-0815 S-2300 S-4200
#expected result
origin/story-S1234-implement_fancy_new_feature origin/story-S-0815-added_new_default_campaign origin/story-S-2300-illuminate_the_planet origin/story-S-4200-the_answere_to_all_questions
```

## Create Release Branch And Merge Branches Into It

```
#assumed you want to:
#   * create new release from branch develop
#   * new release branch should get the name 'release-0.8.15'
*   * you want to merge origin/story-S1234-implement_fancy_new_feature origin/story-S-0815-added_new_default_campaign
#   * you are currently on branch 'defect-fix_broken_unit_tests'
./bin/net_bazzline_create_release_branch develop release-0.8.15 origin/story-S1234-implement_fancy_new_feature origin/story-S-0815-added_new_default_campaign
#expected result
release "release-0.8.18" created with following branches merged:
    origin/story-S1234-implement_fancy_new_feature
    origin/story-S-0815-added_new_default_campaign
```

## Continue Merging Branches Into Release Branch


If a merge results in a conflict, use "net_bazzline_continue_release_branch" to continue merging.

```
#assumed you need to:
*   * continue to an already local existing branch named "release-0.8.18" you have checked out already
*   * you have resolved the conflict you have and commited that change already
*   * you want to merge origin/story-S1234-implement_fancy_new_feature origin/story-S-0815-added_new_default_campaign
./bin/net_bazzline_continue_release_branch origin/story-S1234-implement_fancy_new_feature origin/story-S-0815-added_new_default_campaign
#expected result
continued release creation "release-0.8.18" with following branches merged:
    origin/story-S1234-implement_fancy_new_feature
    origin/story-S-0815-added_new_default_campaign
```

# Install

# History

* upcomming
    * @todo
        * create "net_bazzline_create_difference_between_branches" <path to configuration file> <current tag or release branch> <next release branch> <output directory>
            * configuration
                * commit_message_prefixes
                    * summarized (like 'D-' => 'Defects', 'styled' => 'Styled')
                    * skipped (like 'merged', 'styled')
                * paths
                    * merge_new_files_to_one_in ('path/to/database/changes/' => 'file_name')
                * files
                    * dump_changes ('path/to/important/file' => 'file_name')
        * create "net_bazzline_create_tag_from_release_branch" <release branch> <tag> [<branch to merge release branch> [...]]
        * make the scripts independend by the current working directory
            * path_to_repository as optional parameter
* [0.6.2](https://github.com/bazzline/php_component_database_file_storage/tree/0.6.2) - released at 13.09.2015
