import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {ObjectsList} from "../../../Core/js/ObjectsList/objectsList";
import {FieldTypeRegistry} from "../FieldTypes/FieldTypeRegistry";
import {Ajax} from "../../../Core/js/ajax";

export class list {
    constructor(page, data) {
        console.log('aaaaa');

        const container = page.querySelector('.externalDataList');
        let datasource = new DatasourceAjax('ExternalData', 'getTable', ['ExternalData'], {objectName: data.objectName}, 'updateMultiple');
        let objectsList = new ObjectsList(datasource);
        objectsList.allowTableEdit = true;
        objectsList.columns = Object.entries(data.schema.fields).map(([name, config]) => ({
            name: name,
            content: row => row[name],
            dataName: name,
            sortName: name
        }));
        console.log(objectsList.columns);
        container.append(objectsList);
        objectsList.refresh();
    }
}

export class add {
    constructor(page, data) {
        console.log('add');

        const container = page.querySelector('.externalDataForm');
        for (const [name, config] of Object.entries(data.schema.fields)) {
            if(!config.writable) continue;
            const label = document.createElement('label');
            label.dataset.name = name;
            const span = document.createElement('span');
            span.textContent = name;
            label.append(span);
            const field = FieldTypeRegistry.generate(config);
            label.append(field ?? 'Typ nie obsługiwany');
            container.append(label);
        }
        page.querySelector('form').onsubmit = async (e) => {
            e.preventDefault();
            const obj = {};
            for (const [name, config] of Object.entries(data.schema.fields)) {
                if(!config.writable) continue;
                const label = container.querySelector(`label[data-name="${name}"]`);
                obj[name] = FieldTypeRegistry.readData(label.lastChild, config);
            }
            console.log(obj);
            await Ajax.ExternalData.insert(data.objectName, obj);
        }
    }
}
