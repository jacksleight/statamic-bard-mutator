# Changelog

## 2.3.1 (2024-05-07)

- Statamic 5 support

## 2.3.0 (2023-06-07)

- [new] Include Bard field object in metadata

## 2.2.1 (2023-05-16)

- Add method annotations to the Mutator facade

## 2.2.0 (2023-05-02)

- [new] Statamic 4 support

## 2.1.1 (2023-03-12)

- [fix] Mutators being called twice for adjacent marks

## 2.1.0 (2023-03-03)

- [new] Ability to inject custom HTML into the data
- [new] Helpers for creating new node and mark objects
- [fix] Italic mark mutators not running
- [fix] Incorrect conversion of legacy tag values

## 2.0.1 (2023-01-31)

- Rename root node to camel case

## 2.0.0 (2023-01-31)

- [new] Statamic 3.4 support
- [new] HTML mutators replace tag mutators
- [new] Support for Bard's `save_html` option with reverse mutators
- [break] There are a couple of breaking changes, refer to the [upgrade guide](https://jacksleight.dev/docs/bard-mutator/upgrade-1-0-to-2-0) for more information
- Advanced features are now much easier to enable

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
- [new] Brand new [documentation](https://jacksleight.dev/docs/bard-mutato/) that's better organised and with more information and examples 

## 1.0.4 (2022-04-10)

- [fix] Fix utility function import

## 1.0.3 (2021-12-03)

- [fix] Fix Tiptap schema normalization

## 1.0.2 (2021-12-03)

- [fix] Fix JS error on earlier Statamic versions

## 1.0.1 (2021-12-02)

- [fix] Addon JS script loading

## 1.0.0 (2021-12-01)

- Now only replaces classes of nodes/marks that are actually being mutated
- Ability to mutate Tiptap extension schemas and commands (requires Statamic 3.2.24+)

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
