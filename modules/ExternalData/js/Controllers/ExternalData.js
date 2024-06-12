import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {ObjectsList} from "../../../Core/js/ObjectsList/objectsList";
import {FieldTypeRegistry} from "../FieldTypes/FieldTypeRegistry";
import {Ajax} from "../../../Core/js/ajax";
import {pageManager} from "../../../Core/js/pageManager";

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
        objectsList.generateActions = (rows, mode) => {
            let ret = [];
            if (rows.length == 1) {
                ret.push({
                    name: "Edytuj",
                    icon: 'icon-edit',
                    href: "/ExternalData/edit/"+data.objectName+"/" + rows[0]._id,
                    main: true,
                    action: 'edit'
                });
            }
            return ret
        };
        console.log(objectsList.columns);
        container.append(objectsList);
        objectsList.refresh();
    }
}

class addOrEdit {
    constructor(page, data) {
        this.data = data;
        this.page = page;
    }

    generateForm(data) {
        const container = this.page.querySelector('.externalDataForm');
        for (const [name, config] of Object.entries(this.data.schema.fields)) {
            if (!config.writable) continue;
            const label = document.createElement('label');
            label.dataset.name = name;
            const span = document.createElement('span');
            span.textContent = name;
            label.append(span);
            const field = FieldTypeRegistry.generate(config, data?.[name]??null);
            label.append(field ?? 'Typ nie obsługiwany');
            container.append(label);
        }
    }

    readForm() {
        const container = this.page.querySelector('.externalDataForm');
        const obj = {};
        for (const [name, config] of Object.entries(this.data.schema.fields)) {
            if (!config.writable) continue;
            const label = container.querySelector(`label[data-name="${name}"]`);
            obj[name] = FieldTypeRegistry.readData(label.lastChild, config);
        }
        return obj;
    }
}

export class edit extends addOrEdit {

    constructor(page, data) {
        super(page, data);
        console.log('edit');

        this.generateForm(data.data)
        page.querySelector('form').onsubmit = async (e) => {
            e.preventDefault();
            const obj = this.readForm();
            console.log(obj);
            await Ajax.ExternalData.update(data.objectName,data.data.id, obj);
            pageManager.goto('/ExternalData/list/'+data.objectName)
        }
    }
}

export class add extends addOrEdit {
    constructor(page, data) {
        super(page, data);
        console.log('add');

        this.generateForm()
        page.querySelector('form').onsubmit = async (e) => {
            e.preventDefault();
            const obj = this.readForm();
            console.log(obj);
            await Ajax.ExternalData.insert(data.objectName, obj);
            pageManager.goto('/ExternalData/list/'+data.objectName)
        }
    }
}
