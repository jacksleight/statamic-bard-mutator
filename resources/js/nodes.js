import MutatesNode from './Mixins/MutatesNode'

const { core, extensions } = Statamic.$bard.tiptap;

export class Blockquote extends MutatesNode(extensions.Blockquote) {}
export class BulletList extends MutatesNode(extensions.BulletList) {}
export class CodeBlock extends MutatesNode(extensions.CodeBlock) {}
export class HardBreak extends MutatesNode(extensions.HardBreak) {}
export class Heading extends MutatesNode(extensions.Heading) {}
export class HorizontalRule extends MutatesNode(extensions.HorizontalRule) {}
export class Image extends MutatesNode(extensions.Image) {}
export class ListItem extends MutatesNode(extensions.ListItem) {}
export class OrderedList extends MutatesNode(extensions.OrderedList) {}
export class Paragraph extends MutatesNode(core.Paragraph) {}
export class Table extends MutatesNode(extensions.Table) {}
export class TableCell extends MutatesNode(extensions.TableCell) {}
export class TableHeader extends MutatesNode(extensions.TableHeader) {}
export class TableRow extends MutatesNode(extensions.TableRow) {}
