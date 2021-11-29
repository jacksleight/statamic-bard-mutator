import {
    Blockquote,
    BulletList,
    CodeBlock,
    HardBreak,
    Heading,
    HorizontalRule,
    Image,
    ListItem,
    OrderedList,
    Paragraph,
    Table,
    TableCell,
    TableHeader,
    TableRow,
} from './Nodes.js';
import {
    Bold,
    Code,
    Italic,
    Link,
    Strike,
    Underline,
    Subscript,
    Superscript,
} from './Marks.js';
import Mutator from './Mutator.js';

const mutator = new Mutator({
    blockquote     : Blockquote,
    bullet_list    : BulletList,
    code_block     : CodeBlock,
    hard_break     : HardBreak,
    heading        : Heading,
    horizontal_rule: HorizontalRule,
    image          : Image,
    list_item      : ListItem,
    ordered_list   : OrderedList,
    paragraph      : Paragraph,
    table          : Table,
    table_cell     : TableCell,
    table_header   : TableHeader,
    table_row      : TableRow,
    bold           : Bold,
    code           : Code,
    italic         : Italic,
    link           : Link,
    strike         : Strike,
    subscript      : Subscript,
    superscript    : Superscript,
    underline      : Underline,
});

window.BardMutator = {
    mutator,
};