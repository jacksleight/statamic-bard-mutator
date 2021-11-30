const mutatesMark = (superclass) => class extends superclass {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, super.commands(data), data);
    }
};
export default mutatesMark;