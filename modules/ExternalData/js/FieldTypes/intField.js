export default {
    generate(config, value) {
        const input = document.createElement('input');
        input.type = 'number';
        input.value = value??'';
        input.step = 1;
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
