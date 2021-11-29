import { extendSchema, extendCommands } from "./utilities";

export default class Mutator {

    extensions = {}

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
            schema = mutator(schema, { extendSchema });
        }
        return schema;
    }

    commands(type, callback) {
        this.registerType(type);
        this.commandsMutators[type].push(callback);
        return this;
    }
    
    getCommandsMutators(type) {
        return this.commandsMutators[type] || [];
    }
    
    mutateCommands(type, data, commands) {
        const mutators = this.getCommandsMutators(type);
        if (!mutators.length) {
            return commands;
        }
        for (const mutator of mutators) {
            commands = mutator(data, commands, { extendCommands: (...args) => extendCommands(type, ...args) });
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
            Statamic.$bard.replaceExtension(type, ({ extension }) => new this.extensions[type](extension.options));
        }
    }
    
}