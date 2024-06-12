import {DatasourceAjax} from "../../../Core/js/datasourceAjax";
import {ObjectsList} from "../../../Core/js/ObjectsList/objectsList";

export class list {
    constructor(page, data) {
        console.log('aaaaa');

        const container = page.querySelector('.externalDataList');
        let datasource = new DatasourceAjax('ExternalData', 'getTable', ['ExternalData'], {objectName:data.objectName}, 'updateMultiple');
        let objectsList = new ObjectsList(datasource);
        objectsList.allowTableEdit = true;
        objectsList.columns = Object.entries(data.schema.fields).map(([name,config]) => ({
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
