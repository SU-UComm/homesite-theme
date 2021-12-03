# Dev Setup

This project uses Node.js, npm and grunt for task and package management.
___

**All cli commands found below should be executed at the root of this dev directory, NOT the project root.**
___

## Table of Contents

* System Requirements
	* Installation
	* Troubleshooting
* Development Workflow

## System Requirements

To build and deploy code, you must have the following installed on your system:

* [Node](http://nodejs.org/)
* [Grunt](http://gruntjs.com/getting-started)

### Installation

These tools need only to be installed globally, so if you already have them installed on your system, you are ready to use or add to the toolset.

You may refer to the respective links above for installation instructions for each, but below is a brief overview for each as well:

#### Node

Visit Node's website to download the [installer](http://nodejs.org/).

#### Grunt

The only requirement for Grunt is Grunts CLI(Command Line Utility).
If you don't already have that installed, install globally, this is not project specific.
In NPM we do so with the -g flag.

	npm install -g grunt-cli

## Troubleshooting

* If you have trouble installing any of the tools, you may need to use the `sudo` command.
* If you run into any issues with some of the tasks run, npm rebuild and try again.
	`npm rebuild`
* Also make sure that git is installed globally as some bower packages require it to be fetched and installed.
For grunt specific dependencies, such as compass or sass, check the grunt task dependencies area below.


# Development Workflow

## One-time Setup

The following steps need to be performed once to get your local environment up and running

* `cd` to the local directory where you keep your git repos
* `git clone git@code.stanford.edu:ucomm/homesite-2017.git`
* `cd homesite-2017`
* `git checkout -b wpe/stag origin/wpe/stag`
* `git checkout -b wpe/prod origin/wpe/prod`
* `git checkout -b master`
* `cd dev`
* `nvm use`
* `npm install` - this works with node version 4.4.3; if it doesn't work for you use `nvm` to switch to `node` v4.x
* `mkdir deploy` - create the deploy directory within dev (this is where files will get added to push to WP Engine)
* `cd deploy`
* `git init` - initialize a new git repo within dev/deploy (for WP Engine)
* `git add .` - add the repo to commit
* `git commit -m Initialize` -- commit the new repo

**TO DO:**

* Document setting up `wp-config.php` using `local-config-sample.php` and getting WordPress up and running


## Workflow

### Development
Development work is done on the `master` branch, or on a `feature/` branch, which is then merged into `master`.

* `git checkout master`, or the appropriate feature branch
* `cd dev; nvm use; grunt dev` - have grunt watch for changes and automatically build assets necessary for testing locally
* If working on a `feature` branch, merge to `master` when appropriate.

### Deploy to staging

When the work is ready for deployment to stag, the work is merged to the `wpe/stag` branch
and deployed to staging.

**Note: The deploy process commits, pushes and deploys everything in your working directory.
Before deploying, ensure that all your changes are committed and your working directory is clean.**

Here are the steps in detail:

* If you've been working on a feature branch:
    * If changes have been made to `master` since you created your branch, merge `master` into your branch and resolve any merge conflicts on your branch.
    * Merge your feature branch into `master`.
* Check out the `wpe/stag` branch.
* Merge `master` into the `wpe/stag` branch.
    * If there's a conflict on the build timestamp, resolve it. It doesn't matter which timestamp you keep, as it will be overwritten in a subsequent step.
* `cd dev` (if you're not already in the dev directory of your local repo)
* `nvm use`
* `grunt dist` to build the assets to be deployed
* Test again locally to ensure that the code you're about to deploy behaves the way you expect, and that there are no regressions.
* `grunt deploy --target='wpe-stag'` or just `grunt deploy`, as `wpe-stag` is the default target.
* **Validate your work on https://suhomestag.wpengine.com/ .**

### Deploy to production

**Before deploying to prod, you should deploy and validate your code in the stag environment.**

When the work is ready for deployment to production, the work is merged to the `wpe/prod` branch
and deployed to the live site.

**Note: The deploy process commits, pushes and deploys everything in your working directory.
Before deploying, that all your changes are committed and your working directory is clean.**

Here are the steps in detail:

* After you've deployed and validated your work on WP Engine stag, the code in `master` (and `wpe/stag`) should be ready to deploy to prod.
* Check out the `wpe/prod` branch.
* Merge `master` into the `wpe/prod` branch.
    * If there's a conflict on the build timestamp, resolve it. It doesn't matter which timestamp you keep, as it will be overwritten in a subsequent step.
* `cd dev` (if you're not already in the dev directory of your local repo)
* `nvm use`
* `grunt dist` to build the assets to be deployed
* Test again locally to ensure that the code you're about to deploy behaves the way you expect, and that there are no regressions.
* `grunt deploy --target='wpe-prod'` to actually deploy the code to the live site.
* **Validate your work on https://www.stanford.edu .**
