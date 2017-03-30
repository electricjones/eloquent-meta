# Contributing
Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [Github](https://github.com/chrismichaels84/midas).

To contribute to this project:
  * **Fork or clone** this repository. All work is done in the development branch which may have many feature branches. The master is always the latest, production ready release.
  * **Build** the library on your local machine.
  * **Commit** your changes. All active files are in the /src/ directory.
  * **TestModel** as needed. Write tests and add them to one of the test suites in /tests/. Please write new tests as needed and make sure you didn't break another test.
  * **Issue a Pull Request** on this repository.
  
Be sure to be active. All discussion takes place in issue.
Phoenix Eloquent Meta is licenced under the MIT open source licence.

## Pull Requests
- **[PSR-2 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)** - The easiest way to apply the conventions is to install [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer).

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/). Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

## Running Tests
``` bash
$ phpunit
```

## Branches
The **master** branch always contains the most up-to-date, production ready release. In most cases, this will be the same as the latest release under the "releases" tab.

the **develop** branch holds work in progress for point releases (v0.1.**2**). Any work here should be stable. The idea is that a patch for a security or refactor PR is merged into this branch. Once enough patches have been applied here, it will be merged into `master` and released. This branch should always be stable.

**feature-** branches hold in progress work for upcoming features destined for future major or minor releases. These can be unstable.

**patch-** branches hold in progress patches for upcoming point releases, security patches, and refactors. These can be unstable.

Be sure to fetch often so you keep your sources up-to-date!

**Happy coding**!
