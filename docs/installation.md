---
title: Installation
order: 2
---

# Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/statamic-bard-mutator
```

## Enabling Advanced Features

Advanced features such as [data mutators](mutators#data-mutators) and [metadata](mutators#metadata) require deeper access to Tiptap's rendering process, which isn't avaliable by default. Bard Mutator includes an extended Tiptap Editor class that makes this access possible. To enable these features simply bind the Bard Mutator Editor class in your app service providers `register()` method:

```php
$this->app->bind(
    \Tiptap\Editor::class,
    \JackSleight\StatamicBardMutator\Editor::class
);
```

If you don't want to use those features you don't need to do this, all other features work without it.