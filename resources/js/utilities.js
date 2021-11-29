export const normalizeSchema = schema => {
    if (!schema.attrs) {
        schema.attrs = {};
    }
    return schema;
};

export const normalizeParseDOM = parseDOM => {
    parseDOM.forEach(parseDOMItem => {
        if (!parseDOMItem.getAttrs) {
            parseDOMItem.getAttrs = () => ({});
        }
    });
    return parseDOM;
};

export const normalizeToDOMValue = value => {
    if (!value[1] || !_.isPlainObject(value[1])) {
        value.splice(1, 0, {});
    }
    return value;
};

export const extendSchema = (schema, { attrs, parseDOMAttrs, toDOMAttrs }) => {
    normalizeSchema(schema);
    if (attrs) {
        Object.assign(schema.attrs, attrs);
    }
    if (parseDOMAttrs) {
        const parseDOM = normalizeParseDOM(schema.parseDOM);
        parseDOM.forEach(parseDOMItem => {
            const current = parseDOMItem.getAttrs;
            parseDOMItem.getAttrs = dom => {
                const value = current(dom);
                Object.assign(value, parseDOMAttrs(dom));
                return value;
            };
        });        
    }
    if (toDOMAttrs) {
        const toDOM = schema.toDOM;
        const current = toDOM;
        schema.toDOM = node => {
            const value = normalizeToDOMValue(current(node));
            Object.assign(value[1], toDOMAttrs(node));
            return value;
        };
    }
    return schema;
}

export const normalizeCommands = (name, commands) => {
    if (typeof commands === 'function') {
        commands = { [name]: commands }
    }
    return commands;
}

export const extendCommands = (name, commands, additional) => {
    commands = normalizeCommands(name, commands);
    Object.assign(commands, additional);
    return commands;
}