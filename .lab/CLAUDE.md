# Bard Mutator Lab

A Statamic 6 site that exists only to develop and test `jacksleight/statamic-bard-mutator`. The package is pulled in over a composer path repository (`../statamic-bard-mutator`, constraint `*`), so `vendor/jacksleight/statamic-bard-mutator` is a symlink into the package's working tree and edits there are live here with no rebuild. The lab always sees whatever branch the package is on, including uncommitted work. The package is PHP only, so there are no CP assets to publish or symlink.

Herd parks `~/Packages`, so the site answers on http://statamic-bard-mutator--lab.test/ with no vhost step. The control panel is at `/cp`.

## How plugins are wired

`AppServiceProvider::boot()` requires every file in `app/Mutator/Tests/` and then `app/Mutator/Demos/`, alphabetically. Each file is a plain script of `Mutator::...` calls, named after the entry it serves. Class based plugins live in `app/Mutator/Plugins/` and are registered from `app/Mutator/Tests/class-plugin.php`; the demo classes live in `app/Mutator/Plugins/Demos/` and are registered from `app/Mutator/Demos/plugins.php`.

**Every test and demo plugin is scoped** (`->scoped(true)->handle('test_...')` or `demo_...`, or `$scoped` on the class) and enabled through `bmu_plugins` on that entry's own Bard field, so the tests do not bleed into each other. The two deliberate exceptions are global: the horizontal rule plugin in `scoped.php` (it adds `data-global` to every `hr` on every page) and the blockquote parse plugin in `save-html.php`.

`app/Tags/Lab.php` is the lab's own tag: `{{ lab:source }}` prints a plugin file, `{{ lab:pretty }}` pretty-prints a field's rendered HTML, `{{ lab:plugins }}` lists every registered plugin with its handle, display, scope and options, and `{{ lab:preprocess }}` / `{{ lab:roundtrip }}` run a field's `preProcess()` and `process()`.

## Tests

One collection, `tests`, routed at `/tests/{slug}`. Each entry has its own blueprint in `resources/blueprints/collections/tests/`, its own template in `resources/views/tests/`, a `plugin` field naming its plugin file and a `summary` that drives the index. Every template shows the plugin source, then each Bard field rendered and as escaped HTML source. **The source panel is the point of the lab.**

| Entry | Plugin handle | What it exercises |
| ----- | ------------- | ----------------- |
| `/tests/html-all-types` | `test_html_all_types` | `data-bmu` on every node and mark type HTML plugins support, on content holding all of them. Its field is `listable: true` and its blueprint is the collection's default (`order: 1`), so the CP listing exercises the `pre-process-index` hook |
| `/tests/html-recipes` | `test_html_recipes`, `test_html_recipes_images` | Every HTML recipe in `docs/examples.md`. The paragraph around images recipe has its own handle and field (see Findings) |
| `/tests/data-recipes` | `test_data_recipes` | Every data recipe in `docs/examples.md`: permalink anchors, blockquote to figure, SVG icons on links |
| `/tests/links` | `test_links` | External, protocol relative, same host absolute, root relative, fragment, mailto, tel and `statamic://` links, with the raw `URL::isExternal` result |
| `/tests/data-helpers` | `test_data_helpers` | A `bmuRoot` data plugin driving every `Data::` helper from marker paragraphs: node, mark, text, html in tag and raw mode, apply, clone, morph, walk |
| `/tests/info` | `test_info` | `$info` index, depth, parent, prev, next, root and bard as data attributes |
| `/tests/class-plugin` | `class_test`, `handle_property`, `handle_setter`, `options_test` | `Plugin` subclasses. The first field enables the intended handles (`from_property`, `from_setter`), the second the handles the plugins actually report |
| `/tests/scoped` | `test_scoped` | Two fields, the scoped plugin on the first only, plus the global `hr` plugin on both |
| `/tests/marks` | `test_marks` | Adjacent, combined and overlapping marks, with bold replaced by a nested HTML value |
| `/tests/sets` | `test_sets` | Bard with sets and a `set` data plugin |
| `/tests/inline` | `test_inline` | An inline Bard field |
| `/tests/save-html` | `test_save_html` | `save_html: true`: render on save, parse when the CP converts the stored HTML back |
| `/tests/images` | `test_images` | Images rendered through `resources/views/partials/image.antlers.html` with Glide |
| `/tests/modifiers` | `test_modifiers` | `bard_items`, `bard_text` and `bard_html` against a scoped plugin |
| `/tests/aliases` | `test_aliases` | Snake case type aliases: `code_block`, `unordered_list`, `ordered_list`, `list_item` |
| `/tests/deprecated` | `test_deprecated` | `Mutator::renderHtml` / `parseHtml` and the `$data`, `$meta`, `$type` closure arguments |

The home page at `/` lists them all, links the CP listing and the blueprint editor, and tables every registered plugin.

## Demos

A second collection, `demos`, routed at `/demos/{slug}` (layout `demo`, template `demos/show`). **Each demo runs exactly the plugin code shown on one of the package's marketplace gallery slides**, scoped to that entry, so a slide's Output panel can be checked against real rendered HTML. The template shows the article, the plugin source and the pretty-printed HTML.

| Entry | Plugin file | Slide |
| ----- | ----------- | ----- |
| `/demos/external-links` | `app/Mutator/Demos/external-links.php` | HTML: external link class |
| `/demos/plugins` | `app/Mutator/Demos/plugins.php`, registering the classes in `app/Mutator/Plugins/Demos/` | Plugins: the `LazyImages` class, plus the field's Mutator Plugins setting in the blueprint editor |
| `/demos/permalinks` | `app/Mutator/Demos/permalinks.php` | Data: permalink anchors |

Demo copy is short, light and written from nobody's point of view: plain guide-style text about Brighton. The slides themselves are content on the package entry in `~/Projects/jacksleight` (the `code-slides` skill), and their code is the demo file minus the `use` lines and the `->scoped()->handle()` chain (for the plugins demo, the class file minus its `namespace` and `use` lines). **Change a demo and the matching slide's Output panel has to change with it**, and the reverse.

The plugins demo's three classes (`ExternalLinks`, `HeadingAnchors`, `LazyImages`) are scoped and enabled on the `plugins` blueprint's Bard field as `external_links`, `heading_anchors` and `lazy_images`. They are named so the default handle and display read well, which also kept them working before 3.0.6 fixed custom class plugin handles. The slide's screenshot of the field's Mutator Plugins setting is taken from that blueprint, by the `statamic-bard-mutator` manifest in the site's `code-capture` skill.

## Findings

Confirmed in this lab on statamic/cms 6.39 and recorded, not fixed (the fixes are a separate pass):

- **Fixed in 3.0.6: a class plugin's custom handle was ignored.** `Plugin::handle()` returned `$handle ?: Str::snake(...)`, where `$handle` was the null argument rather than `$this->handle`, so both a `protected ?string $handle` and `->handle('x')` were dropped and the plugin always reported its snake cased class name. On `/tests/class-plugin` the intended handles field now runs both plugins and the actual handles field runs neither; the page's headings still describe the old behaviour.
- **`options([])` sets correctly; `options(null)` throws.** `func_get_args()` is `[[]]`, which is truthy, so the reported `options([])` bug does not reproduce. Passing `null` assigns null to the typed `array $options` and throws a `TypeError`.
- **`Data::html()` raw mode puts its second argument into `marks`, not attrs.** The docs signature reads `$attrs`. Passing an attributes array there crashes the render with `Unsupported operand types: string - int` from `Data::walk()`, which subtracts from the string key. The docs' own SVG link recipe relies on the marks behaviour by passing `$node->marks`.
- **The docs call `str_slug()`, which does not exist** in Laravel 13 (`function_exists` is false). The lab uses `Str::slug`. The email obfuscation recipe also needs `use Illuminate\Support\Str` and `use Statamic\Statamic`, and carries a stray `use (&$obfuscated)`.
- **Fixed in 3.0.6: a plugin that returned `null` crashed every later plugin for the same type.** The next plugin's `render(array $value, ...)` received null and threw a `TypeError`. A `null` return now skips the later HTML plugins for that item, so the docs' two paragraph recipes can run on one field. The images recipe still has its own handle here from before the fix.
- **Fixed in 3.0.6: `$info->prev`, `next` and `parent` threw at the edges.** `Info::__get()` passed the null sibling or parent straight to `fetchInfo()`, and a `WeakMap` key must be an object. They now return null there, so the info test's `rescue()` wrappers never fire and its output shows `-` at every first and last child.
- **A raw object added in a data plugin crashes the walk.** A node added as `(object) [...]` rather than through `Data::` is not marked processed, gets walked, has no info, and `mutateData()` reads `$info->bard` on null. Use the `Data::` helpers.
- **An integer `0` attribute value breaks the tag.** tiptap-php's serializer treats any array containing a strict `0` as a nested render instruction, so `$value[1]['data-index'] = 0` turns the attributes into child elements. Cast to a string.
- **Scoped plugins never run in parse or in the Bard modifiers.** Parse mode builds a dummy item with no info, so only global parse plugins run (`/tests/save-html`: the scoped `div[data-scoped]` rule is ignored, the global `div[data-global]` one turns the div into a blockquote). `bard_html` and friends build `new Bard()` with no field, so scoped plugins are skipped there and global ones still run (`/tests/modifiers`).
- **A `set` data plugin cannot change the set's values.** Statamic captures the set values before the augment hooks run, so `$item->attrs->values` edits are lost; inserting nodes around a set works.
- **`URL::isExternal()` is true for `mailto:`, `tel:` and protocol relative URLs.** The external link recipe therefore puts `class="external"` on mail links.
- **The CP listing renders every row with the collection's default blueprint**, so the scoped plugins on that one blueprint's field apply to every entry's `content` column. Statamic behaviour, not the package's.

From the website's pre-launch QA on 2026-10-30, also not fixed:

- **The email obfuscation recipe produces a double-encoded `mailto:`**, most likely because `obfuscateEmail` returns HTML entities that the serializer escapes a second time.
- **HTML plugins probably never reach Texstyle's `btsSpan` and `btsDiv`**, although `docs/available-types.md` lists them: Texstyle dropped the Mutator trait in 2.0 (`3e11ef5`). Read from source, not run.

**Nothing broke on Statamic 6.** Rendering, every node and mark type, sets, inline fields, `save_html` saves, the `pre-process-index` hook, every CP entry screen and a CP `PATCH` round trip all work. The Mutator Plugins option appears in the Bard field settings, in the Main tab's first, unnamed section.

## Things to know

- **`bmu_plugins` takes handles, one per list item.** A handle that no registered plugin reports is silently ignored.
- **Statamic only offers the Mutator Plugins setting when at least one scoped plugin with a handle exists**, which here is always.
- **The CP listing for `tests` defaults to `html_all_types`** because of `order: 1` on that blueprint. Remove it and the listing falls back to the alphabetically first blueprint.
- **The save-html entry's body is stored HTML**, produced by running the field's `process()` (so its `data-saved` attribute is real render-on-save output), with two hand-written divs appended for the parse rules.
- **Assets** are in `public/assets`, container handle `assets`. `sample.jpg` is a resized copy of `image1.jpg` from the Dropbox samples.

## Rebuilding

This lab is disposable, and everything in it worth keeping is baked into `.lab/` in the package repo, a flat mirror of these paths copied over a fresh `statamic new` shell. To rebuild, run the `setup-lab` skill. To add something that should survive a rebuild, re-run `setup-lab` with that instruction; it makes the change here, verifies it, and bakes the changed files into `.lab/`. Do not edit `.lab/` by hand, and never sync the whole lab into it.

Entry files are baked verbatim, UUIDs included. There is no seed script.

## Commands

- `npm run dev` for the frontend in watch mode, `npm run build` for a production build
- Always `herd php` and `herd composer`, never bare `php`

## Skip (local login)

Local-only login bypass from the machine's skip package (`~/Packages/skip`), configured in `.claude/skip.json`: `GET /!/skip/{handle}` logs in as `{handle}@example.test` and lands on `?redirect=` (a path on this site) or the handle's own `redirect`. Example: `/!/skip/admin`. A listed handle with no user yet is created on its first login, with the password `password`.
