---
id: 720f5f4d-19d2-4b5f-8188-944c91b45446
blueprint: class_plugin
title: 'Class Plugin'
summary: 'Plugin subclasses: auto handle, a custom $handle property, a handle set with ->handle(), and options(). The first field enables the intended handles, the second the handles the plugins actually report.'
plugin: Tests/class-plugin
template: tests/class-plugin
intended:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'A heading'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'A paragraph.'
  -
    type: blockquote
    content:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'A blockquote.'
  -
    type: bulletList
    content:
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'A bullet list'
actual:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'A heading'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'A paragraph.'
  -
    type: blockquote
    content:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'A blockquote.'
  -
    type: bulletList
    content:
      -
        type: listItem
        content:
          -
            type: paragraph
            content:
              -
                type: text
                text: 'A bullet list'
---
