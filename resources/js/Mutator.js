import { extendSchema } from "./utilities";

export default class Mutator {

    extensions = null

    registered = []

    schemaMutators = {}

    commandsMutators = {}

    constructor(extensions) {
        this.extensions = extensions;
    }

    schema(type, callback) {
        this.registerType(type);
        this.schemaMutators[type].push(callback);
        return this;
    }

    getSchemaMutators(type) {
        return this.schemaMutators[type] || [];
    }

    mutateSchema(type, schema) {
        const mutators = this.getSchemaMutators(type);
        if (!mutators.length) {
            return schema;
        }
        for (const mutator of mutators) {
            schema = this.normalizeSchema(type, schema);
            schema = mutator(schema, { extendSchema });
        }
        return schema;
    }

    normalizeSchema(type, schema) {
        if (!schema.attrs) {
            schema.attrs = {};
        }
        return schema;
    };

    commands(type, callback) {
        this.registerType(type);
        this.commandsMutators[type].push(callback);
        return this;
    }
    
    getCommandsMutators(type) {
        return this.commandsMutators[type] || [];
    }
    
    mutateCommands(type, commands, info) {
        const mutators = this.getCommandsMutators(type);
        if (!mutators.length) {
            return commands;
        }
        for (const mutator of mutators) {
            commands = this.normalizeCommands(type, commands);
            commands = mutator(commands, info);
        }
        return commands;
    }
    
    normalizeCommands(type, commands) {
        if (typeof commands === 'function') {
            commands = { [type]: commands };
        }
        return commands;
    }

    registerType(type) {
        if (this.registered.includes(type)) {
            return;
        }
        this.registered.push(type);
        this.schemaMutators[type] = [];
        this.commandsMutators[type] = [];
        if (this.extensions[type]) {
            const replace = this.extensions[type];
            Statamic.$bard.replaceExtension(type, ({ extension }) => new replace(extension.options));
        }
    }
    
}