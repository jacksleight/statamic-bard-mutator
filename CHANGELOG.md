# Changelog

## 0.1.4 (2021-09-29)

- The API has been simplified, you no longer need to worry about whether you need to call `Mutator::node()` or `Mutator::mark()`, just use `Mutator::tag()` for everything. Previous methods remain in place for BC for now.

## 0.1.3 (2021-09-24)

- [fix] Support back to Statamic 3.1.14
- Tweak to the trait API

## 0.1.2 (2021-09-23)

- [break] Removed class configuration as it could potentially cause issues with future ProseMirror/Statamic updates or other addons, needs more thought

## 0.1.1 (2021-09-23)

- Tweak config keys

## 0.1.0 (2021-09-23)

- Initial release
