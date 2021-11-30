import mutatesMark from './mixins/mutates-mark'

const { extensions } = Statamic.$bard.tiptap;

export class Bold extends mutatesMark(extensions.Bold) {}
export class Code extends mutatesMark(extensions.Code) {}
export class Italic extends mutatesMark(extensions.Italic) {}
export class Link extends mutatesMark(extensions.Link) {}
export class Strike extends mutatesMark(extensions.Strike) {}
export class Subscript extends mutatesMark(extensions.Subscript) {}
export class Superscript extends mutatesMark(extensions.Superscript) {}
export class Underline extends mutatesMark(extensions.Underline) {}