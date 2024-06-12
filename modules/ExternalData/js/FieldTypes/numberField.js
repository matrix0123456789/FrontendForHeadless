export default {
    generate(){
      const input = document.createElement('input');
        input.type = 'number';
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
