---
id: 09617832-35f0-4fc4-9160-726b3b81b15c
blueprint: links
title: Links
summary: 'Links classified as external, internal or mailto, with the raw URL::isExternal result beside each.'
plugin: Tests/links
template: tests/links
content:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'External https'
        marks:
          -
            type: link
            attrs:
              href: 'https://statamic.com'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Protocol relative'
        marks:
          -
            type: link
            attrs:
              href: //cdn.example.com/file.js
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Absolute on this host'
        marks:
          -
            type: link
            attrs:
              href: 'http://statamic-bard-mutator--lab.test/tests/info'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Root relative'
        marks:
          -
            type: link
            attrs:
              href: /tests/info
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Fragment only'
        marks:
          -
            type: link
            attrs:
              href: '#section'
  -
    type: paragraph
    content:
      -
        type: text
        text: Mailto
        marks:
          -
            type: link
            attrs:
              href: 'mailto:hi@example.com'
  -
    type: paragraph
    content:
      -
        type: text
        text: Tel
        marks:
          -
            type: link
            attrs:
              href: 'tel:+441273000000'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Statamic entry link'
        marks:
          -
            type: link
            attrs:
              href: 'statamic://entry::b7ba461d-7306-4c65-a96b-56226687f509'
---
