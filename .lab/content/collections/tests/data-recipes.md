---
id: b5c051c2-2196-4668-84d1-de9ff4cb3dc2
blueprint: data_recipes
title: 'Data Recipes'
summary: 'Every data plugin recipe from docs/examples.md: permalink anchors, blockquotes as figures, and SVG icons on links.'
plugin: Tests/data-recipes
template: tests/data-recipes
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
