
import Mutator from './mutator.js';

const mutator = new Mutator({
    blockquote     : true,
    bullet_list    : true,
    code_block     : true,
    hard_break     : true,
    heading        : true,
    horizontal_rule: true,
    image          : true,
    list_item      : true,
    ordered_list   : true,
    paragraph      : true,
    table          : true,
    table_cell     : true,
    table_header   : true,
    table_row      : true,
    bold           : true,
    code           : true,
    italic         : true,
    link           : true,
    strike         : true,
    subscript      : true,
    superscript    : true,
    underline      : true,
});

window.BardMutator = {
    mutator,
};