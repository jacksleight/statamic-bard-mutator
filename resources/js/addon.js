
import Mutator from './mutator.js';

const mutator = new Mutator([
    'blockquote',
    'bulletList',
    'codeBlock',
    'hardBreak',
    'heading',
    'horizontalRule',
    'image',
    'listItem',
    'orderedList',
    'paragraph',
    'table',
    'tableCell',
    'tableHeader',
    'tableRow',
    'bold',
    'code',
    'italic',
    'link',
    'strike',
    'subscript',
    'superscript',
    'underline',
]);

window.BardMutator = {
    mutator,
};