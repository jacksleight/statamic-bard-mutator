---
id: f5da9c11-6980-47a8-bd63-9e8c6bb84d7b
blueprint: save_html
title: 'Save HTML'
summary: 'save_html is on, so the field stores HTML. Render plugins run when the entry is saved, not when it is shown. Parse plugins run when the CP converts the HTML back: a scoped one adds div[data-scoped] to paragraphs, a global one adds div[data-global] to blockquotes.'
plugin: Tests/save-html
template: tests/save-html
---
<h2 data-saved="render ran on save">Saved as HTML</h2><p>A paragraph saved as HTML.</p><div data-scoped>Div matched only by the scoped parse rule</div><div data-global>Div matched only by the global blockquote parse rule</div>