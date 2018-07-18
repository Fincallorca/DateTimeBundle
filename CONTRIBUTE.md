# Releasing / Branching

1. Pull the _master_ *and* _develop_ branch:

       git checkout master && git pull && git checkout develop && git pull && git pull --tags && git status

2. Take a look into the [CHANGELOG.md](CHANGELOG.md) to get the new version tag.
3. Start a _hotfix_ or _release_ branch via **git flow**:

       git flow release start VERSION
       git flow hofix start VERSION
       
## Check Classes

If something in class [DateTime](src/Component/DateTime.php) or class [DateTimeImmutable](src/Component/DateTimeImmutable.php) has changed,
please adapt the changes also in the other class.

## Add Changes to History File

1. Add all changes to the [CHANGELOG.md](CHANGELOG.md)
2. Rename _UNRELEASED_ to the new tag and create a new section _UNRELEASED_. 


### Change Tags

Change all current tags, and tags inside the [shields.io](https://img.shields.io/) badges (icon **and** link) in the [README.md](README.md)
```markdown
[![Release](https://img.shields.io/badge/Release-0.0.0-blue.svg?style=flat)](https://github.com/Fincallorca/DateTimeBundle/releases/tag/0.0.0)
```

## Push

1. Close the branch:

       git flow release finish
       git flow hofix finish

2. Push the _master_ and the _develop_ branch and the _tags_:

       git checkout develop && git push && git checkout master && git push && git push --tags && git checkout develop