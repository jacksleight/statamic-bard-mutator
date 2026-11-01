---
id: b5c051c2-2196-4668-84d1-de9ff4cb3dc2
blueprint: data_recipes
title: 'Data Recipes'
summary: 'Every data plugin recipe from docs/examples.md: permalink anchors, blockquotes as figures, SVG icons on links, and obfuscated email links. The email recipe has its own handle and field, because the SVG recipe rewrites every link on the main one.'
plugin: Tests/data-recipes
template: tests/data-recipes
email:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Write to '
      -
        type: text
        text: 'hi@example.com'
        marks:
          -
            type: link
            attrs:
              href: 'mailto:hi@example.com'
      -
        type: text
        text: ', or '
      -
        type: text
        text: 'email the office'
        marks:
          -
            type: link
            attrs:
              href: 'mailto:office@example.com'
          -
            type: bold
      -
        type: text
        text: ' from the '
      -
        type: text
        text: 'contact page'
        marks:
          -
            type: link
            attrs:
              href: /tests/links
      -
        type: text
        text: .
content:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'Permalinks on headings'
  -
    type: blockquote
    content:
      -
        type: paragraph
        content:
          -
            type: text
            text: 'The sea air is free.'
      -
        type: paragraph
        content:
          -
            type: text
            text: 'A Brighton saying'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Read more at '
      -
        type: text
        text: Statamic
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
      -
        type: text
        text: .
---
