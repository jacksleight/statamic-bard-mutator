export default {
    addAttributes() {
        return BardMutator.mutator.mutate('addAttributes', this.name, this.parent());
    },
    addCommands() {
        return BardMutator.mutator.mutate('addCommands', this.name, this.parent());
    },
    parseHTML() {
        return BardMutator.mutator.mutate('parseHTML', this.name, this.parent());
    },
    renderHTML(params) {
        return BardMutator.mutator.mutate('renderHTML', this.name, this.parent(params), params);
    },
};