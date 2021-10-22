# Changelog

## 0.2.0 (2021-10-22)

- [break] **Package Renamed:**  
This package has been renamed to `jacksleight/statamic-bard-mutator`. I'm very sorry for any inconvienence this causes, but it's necessary for some future plans and to keep everything namespaced properly. It won't happen again! Update instructions:
    1. Update `composer.json` to `"jacksleight/statamic-bard-mutator": "0.2.0",`
    2. Update any class references to the new `JackSleight\StatamicBardMutator` namespace
    3. Run `composer update`

## 0.1.4 (2021-09-29)

- Simplified API, `Mutator::node()` and `Mutator::mark()` have been replaced with `Mutator::tag()`

## 0.1.3 (2021-09-24)

- [fix] Support back to Statamic 3.1.14
- Tweak to the trait API

## 0.1.2 (2021-09-23)

- [break] Removed class configuration as it could potentially cause issues with future ProseMirror/Statamic updates or other addons, needs more thought

## 0.1.1 (2021-09-23)

- Tweak config keys

## 0.1.0 (2021-09-23)

- Initial release
