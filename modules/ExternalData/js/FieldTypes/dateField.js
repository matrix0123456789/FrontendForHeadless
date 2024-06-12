export default {
    generate(config, value){
      const input = document.createElement('input');
        input.type = 'date';
        input.value = value??'';
        return input;
    },
    readData(htmlNode) {
        return htmlNode.value;
    }
}
