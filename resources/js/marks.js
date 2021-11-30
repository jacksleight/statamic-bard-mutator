import MutatesMark from './Mixins/MutatesMark'

const { extensions } = Statamic.$bard.tiptap;

export class Bold extends MutatesMark(extensions.Bold) {}
export class Code extends MutatesMark(extensions.Code) {}
export class Italic extends MutatesMark(extensions.Italic) {}
export class Link extends MutatesMark(extensions.Link) {}
export class Strike extends MutatesMark(extensions.Strike) {}
export class Subscript extends MutatesMark(extensions.Subscript) {}
export class Superscript extends MutatesMark(extensions.Superscript) {}
export class Underline extends MutatesMark(extensions.Underline) {}