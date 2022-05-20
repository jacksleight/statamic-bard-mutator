export default {
    addAttributes(params) {
        return BardMutator.mutator.mutate('addAttributes', this.name, this.parent(params), params);
    },
    addCommands(params) {
        return BardMutator.mutator.mutate('addCommands', this.name, this.parent(params), params);
    },
    parseHTML(params) {
        return BardMutator.mutator.mutate('parseHTML', this.name, this.parent(params), params);
    },
    renderHTML(params) {
        return BardMutator.mutator.mutate('renderHTML', this.name, this.parent(params), params);
    },
};