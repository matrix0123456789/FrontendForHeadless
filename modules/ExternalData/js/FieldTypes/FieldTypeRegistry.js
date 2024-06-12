import StringField from "./stringField";
import DateField from "./dateField";
import NumberField from "./numberField";
import IntField from "./intField";

export const FieldTypeRegistry = {
    fieldTypes: {string: StringField, int: IntField, number: NumberField, date: DateField},
    generate(config) {
        if (this.fieldTypes[config.type]) {
            return this.fieldTypes[config.type].generate(config);
        }
    },
    readData(htmlNode, config) {
        if (this.fieldTypes[config.type]) {
            return this.fieldTypes[config.type].readData(htmlNode, config);
        }
    }
}
