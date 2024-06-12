export default {
    generate() {
        const input = document.createElement('input');
        input.type = 'text';
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
