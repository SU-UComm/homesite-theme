# Dev Setup

This project uses Node.js, npm and grunt for task and package management.
___

**All cli commands found below should be executed at the root of the dev directory, NOT the theme directory.**
___

## Table of Contents

* System Requirements
	* Installation
	* Troubleshooting
* Development Workflow

## System Requirements

To build and deploy code, you must have the following installed on your system:

* [nvm](https://github.com/nvm-sh/nvm)
* [npm](https://docs.npmjs.com/about-npm)
* [grunt](http://gruntjs.com/getting-started)

### Installation

These tools need only to be installed globally, so if you already have them installed on your system,
you are ready to use or add to the toolset.

You may refer to the respective links above for installation instructions for each, but below is a
brief overview for each as well:

#### nvm

Follow [these instructions](https://github.com/nvm-sh/nvm#installing-and-updating) to install
nvm (Node Version Manager).

#### npm / node

Use `nvm` to install the proper version of npm / node.

* Identify the right version of npm / node by looking in `dev/.nvmrc`. In our case it's likely 8.
* `nvm install 8`
* `nvm use` to actually use the verion of npm / node specified in `dev/.nvmrc`.

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

* use [Local by Flywheel](https://localwp.com/) to create a local WordPress instance
* `cd wp-content/themes` in your Local install
* `git clone git@github.com:SU-UComm/homesite-theme.git homesite17`
* `cd homesite17/dev`
* `nvm use`
* `npm install`

In December 2022 we embedded the old version/branch of Decanter that is used with this theme instead of pulling it in via NPM because the stale branch would no longer install properly. Before the theme can build correctly you must now install Decanter's dependencies.
* `cd decanter`
* `nvm use`
* `npm install`

Now you should be ready to build from the `dev` directory follwing the steps in Development below.


**Note**: While not strictly necessary for theme development, your local site will not funtion
without the [Stanford Homesite plugin](https://github.com/SU-UComm/homesite-plugin). To install that:

* `cd wp-content/plugins` in your Local install
* `git clone https://github.com/SU-UComm/homesite-plugin stanford-homesite`

**TO DO:**

* Document setting up `wp-config.php` using `local-config-sample.php` and getting WordPress up and running


## Workflow

### Development
Development work is done on the `master` branch, or on a `feature/` branch, which is then merged into `master`.

* `cd wp-content/themes/homesite17`
* `git checkout master`, or the appropriate feature branch
* `cd dev` - all building is done in the `dev/` directory
* `nvm use` - run the right version of grunt, npm, ...
* `grunt dev` - have grunt watch for changes and automatically build assets necessary for testing locally
  * other grunt commands:
  * `grunt build` - build dev versions of the assets
  * `grunt dist` - build production versions of the assets
* If working on a `feature` branch, merge to `master` when appropriate.

### Deploy to dev

When the work is ready for deployment to our dev environment on Pantheon,
the work is merged to the `pantehon` branch and pushed to github. There is a github action
in this repo that automatically deploys any code pushed to the `pantheon` branch to our
[dev environment on Pantheon](https://dashboard.pantheon.io/sites/4a2ec620-f9e5-4895-ac46-ab17b5f823b7#dev/code).

Here are the steps in detail:

* `git checkout pantheon`
* `git merge master` - or whatever branch you want to deploy
* `git push` - push to github; your code should be deployed to Pantheon in ~5 minutes
* `git checkout master` - just so you don't accidentally commit anything directly to the pantheon branch

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
* **Validate your work on http://dev-stanford-homesite.pantheonsite.io/ .**

### Deploy to test and prod

On Pantheon's dashboard to push your code from dev to test. Validate your work on
http://test-stanford-homesite.pantheonsite.io/.

When you're confident your code is ready for production, use Pantheon's dashboard to
push your code to the live environment.
