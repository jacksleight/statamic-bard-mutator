# Changelog

## 1.1.3 (2023-01-12)

- [new] Include root node in metadata

## 1.1.2 (2022-08-18)

- [fix] Tag mutators running twice per opening/closing tag-pair

## 1.1.1 (2022-05-09)

- Support `name` and  `value` parameters in tag
- Update Statamic version requirement

## 1.1.0 (2022-04-28)

- [new] Metadata: Mutators can now get info on the current node/mark’s parent, siblings, index and depth
- [new] Data Mutators: Make changes to the node/mark data before anything is rendered to HTML
- [new] Ability to specify multiple types when adding mutators
- [new] Support for the new "small" mark in Statamic 3.3.9
- [new] Brand new [documentation](https://jacksleight.github.io/statamic-bard-mutator/) that's better organised and with more information and examples 

## 1.0.4 (2022-04-10)

- [fix] Fix utility function import

## 1.0.3 (2021-12-03)

- [fix] Fix TipTap schema normalization

## 1.0.2 (2021-12-03)

- [fix] Fix JS error on earlier Statamic versions

## 1.0.1 (2021-12-02)

- [fix] Addon JS script loading

## 1.0.0 (2021-12-01)

- Now only replaces classes of nodes/marks that are actually being mutated
- Ability to mutate TipTap extension schemas and commands (requires Statamic 3.2.24+)

## 0.2.0 (2021-10-22)

- [break] **Package Renamed:**  
This package has been renamed to `jacksleight/statamic-bard-mutator`. Sorry for any inconvienence this causes, but it's necessary for some future plans and to keep everything namespaced properly. Update instructions:
    1. Update `composer.json` to `"jacksleight/statamic-bard-mutator": "0.2.0",`
    2. Update any class references to the new `JackSleight\StatamicBardMutator` namespace
    3. Run `composer update`

## 0.1.4 (2021-09-29)

- Simplified API, `Mutator::node()` and `Mutator::mark()` have been replaced with `Mutator::tag()`

## 0.1.3 (2021-09-24)

- [fix] Support back to Statamic 3.1.14
- Tweak to the trait API

## 0.1.2 (2021-09-23)

- [break] Removed class configuration

## 0.1.1 (2021-09-23)

- Tweak config keys

## 0.1.0 (2021-09-23)

- Initial release
