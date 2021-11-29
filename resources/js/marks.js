const { extensions } = Statamic.$bard.tiptap;

export class Bold extends extensions.Bold {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Code extends extensions.Code {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Italic extends extensions.Italic {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Link extends extensions.Link {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Strike extends extensions.Strike {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Subscript extends extensions.Subscript {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Superscript extends extensions.Superscript {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Underline extends extensions.Underline {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}