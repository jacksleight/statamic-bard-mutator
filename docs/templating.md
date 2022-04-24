---
title: Templating
nav_order: 3
---

# Templating
{:.no_toc}

<details open markdown="block">
  <summary>
      Table of contents
  </summary>
  {: .text-delta }
* TOC
{:toc}
</details>

---

All tag mutators will be applied whenever any Bard field is output, you don’t need to make any changes to your templates. However, only basic functionality is available with this method.

## The Bard Mutator Tag

To use advanced features such as [metadata](mutators.html#metadata) and [root mutators](mutators.html#root-mutators) you need to use the `bmu` tag. To do this update your template from this:

```html
{% raw %}{{ my_content }}{% endraw %}
```

To this:

```html
{% raw %}{{ bmu:my_content }}{% endraw %}
```