export default {
    generate() {
        const input = document.createElement('input');
        input.type = 'number';
        input.step = 1;
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
