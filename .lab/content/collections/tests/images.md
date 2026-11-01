---
id: e2597462-3717-4b21-b134-12883a18ca47
blueprint: images
title: Images
summary: 'Images rendered through a view partial with Glide, the image partial recipe from the docs.'
plugin: Tests/images
template: tests/images
content:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: 'An image'
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::sample.jpg'
          alt: 'Sample image'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'Text after the image.'
---
