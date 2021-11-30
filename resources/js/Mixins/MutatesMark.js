const MutatesMark = (superclass) => class extends superclass {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
};
export default MutatesMark;