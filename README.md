<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.1.14+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-bard-mutator)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-bard-mutator)

# Bard Mutator 

<!-- /statamic:hide -->

This Statamic addon allows you to modify the data and tags rendered by the Bard fieldtype, giving you full control over the final HTML. You can add, remove and modify attributes, wrap tags and content, or rename and replace tags entirely. You can also make changes the raw data before anything is rendered to HTML.

## Examples

Here are a few examples of what's possible. For more information and more examples check [the documentation](https://jacksleight.dev/docs/bard-mutator/examples).

### Add `noopener` to all external links

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::tag('link', function ($tag) {
    if (URL::isExternal($tag[0]['attrs']['href'])) {
        $tag[0]['attrs']['rel'] = 'noopener';
    }
    return $tag;
});
```

### Add an auto-generated ID to all level 2 headings

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('heading', function ($tag, $data) {
    if ($data->attrs->level === 2) {
        $tag[0]['attrs']['id'] = str_slug(collect($data->content)->implode('text', ''));
    }
    return $tag;
});
```

### Remove paragraph tags inside list items and table cells

```php
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::tag('paragraph', function ($tag, $data, $meta) {
    if (in_array($meta['parent']->type, ['list_item', 'table_cell'])) {
        return null;
    }
    return $tag;
});
```

## Documentation

[Statamic Bard Mutator Documentation](https://jacksleight.dev/docs/bard-mutator)

## Compatibility

In order to run tag mutators Bard Mutator has to replace the built-in classes/extensions with its own. It can only do that reliably if there are no other addons (or user code) trying to do the same thing. To help minimise incompatibilities Bard Mutator will only replace the classes/extensions that are actually being mutated, everyting else is left alone.

*However*, if you have other addons (or user code) that replace any of the classes/extensions that Bard Mutator is also replacing it probably won't work properly. Unfortunately I don’t think there’s a way around that. This does not affect custom nodes and marks.

My other Bard addons use Bard Mutator under the hood, so those are fully compatible. In fact the main reason I developed this in the first place was so multiple addons could make modifications to the built-in classes/extensions at the same time.

## Sponsoring 

This addon is completely free to use. However fixing bugs, adding features and helping users takes time and effort. If you find this addon useful and would like to support its development any [contribution](https://github.com/sponsors/jacksleight) would be greatly appreciated. Thanks! 🙂
