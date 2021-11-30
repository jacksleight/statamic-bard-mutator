const mutatesNode = (superclass) => class extends superclass {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(info) {
        return BardMutator.mutator.mutateCommands(this.name, super.commands(info), info);
    }
};
export default mutatesNode;