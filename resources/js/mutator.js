import mutatesExtension from "./traits/mutates-extension";

export default class Mutator {

    extensions = null

    registered = []

    mutators = {}

    constructor(extensions) {
        this.extensions = extensions;
    }

    mutator(type, kind, callback) {
        // @todo multiple types
        this.registerType(type);
        if (!this.mutators[type]) {
            this.mutators[type] = [];
        }
        if (!this.mutators[type][kind]) {
            this.mutators[type][kind] = [];
        }
        this.mutators[type][kind].push(callback);
    }

    mutate(kind, type, value, params = {}) {
        // @todo normalization
        const mutators = this.mutators[type] && this.mutators[type][kind]
            ? this.mutators[type][kind]
            : [];
        if (!mutators.length) {
            return value;
        }
        for (const mutator of mutators) {
            value = mutator({
                type,
                value,
                ...params,
            });
        }
        return value;
    }

    registerType(type) {
        if (this.registered.includes(type)) {
            return;
        }
        this.registered.push(type);
        if (this.extensions.includes(type)) {
            Statamic.$bard.replaceExtension(type, ({ extension }) => extension.extend(mutatesExtension));
        }
    }

}