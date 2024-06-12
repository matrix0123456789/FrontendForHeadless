export default {
    generate(){
      const input = document.createElement('input');
        input.type = 'date';
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
