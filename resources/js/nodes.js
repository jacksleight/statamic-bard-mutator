const { core, extensions } = Statamic.$bard.tiptap;

export class Blockquote extends extensions.Blockquote {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class BulletList extends extensions.BulletList {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class CodeBlock extends extensions.CodeBlock {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class HardBreak extends extensions.HardBreak {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Heading extends extensions.Heading {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class HorizontalRule extends extensions.HorizontalRule {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Image extends extensions.Image {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class ListItem extends extensions.ListItem {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class OrderedList extends extensions.OrderedList {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Paragraph extends core.Paragraph {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class Table extends extensions.Table {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class TableCell extends extensions.TableCell {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class TableHeader extends extensions.TableHeader {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}

export class TableRow extends extensions.TableRow {
    get schema() {
        return BardMutator.mutator.mutateSchema(this.name, super.schema);
    }
    commands(data) {
        return BardMutator.mutator.mutateCommands(this.name, data, super.commands(data));
    }
}