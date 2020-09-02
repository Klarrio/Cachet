# Merge new commits from CachetHQ/Cachet.git

1. check the branch on CachetHQ/Cachet.git which it the latest (normally master, now 2.4): CACHET_BRANCH
2. Take the branch where you wish to merge cachet developments in: KLARRIO_BRANCH
3. execute:

KLARRIO_BRANCH="2.4.2"
CACHET_BRANCH="2.4"

git remote add cachet git@github.com:CachetHQ/Cachet.git
git checkout $KLARRIO_BRANCH
git fetch cachet $CACHET_BRANCH
git diff cachet/$CACHET_BRANCH
git rebase cachet/$CACHET_BRANCH
git push -f origin $KLARRIO_BRANCH