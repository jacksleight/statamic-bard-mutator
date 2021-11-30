import mutatesNode from './mixins/mutates-node'

const { core, extensions } = Statamic.$bard.tiptap;

export class Blockquote extends mutatesNode(extensions.Blockquote) {}
export class BulletList extends mutatesNode(extensions.BulletList) {}
export class CodeBlock extends mutatesNode(extensions.CodeBlock) {}
export class HardBreak extends mutatesNode(extensions.HardBreak) {}
export class Heading extends mutatesNode(extensions.Heading) {}
export class HorizontalRule extends mutatesNode(extensions.HorizontalRule) {}
export class Image extends mutatesNode(extensions.Image) {}
export class ListItem extends mutatesNode(extensions.ListItem) {}
export class OrderedList extends mutatesNode(extensions.OrderedList) {}
export class Paragraph extends mutatesNode(core.Paragraph) {}
export class Table extends mutatesNode(extensions.Table) {}
export class TableCell extends mutatesNode(extensions.TableCell) {}
export class TableHeader extends mutatesNode(extensions.TableHeader) {}
export class TableRow extends mutatesNode(extensions.TableRow) {}
