/**
 * Created by valik on 26.03.2017.
 */
class FormSelectValueField {
    objLot?: Object;
    objSubstation?: Object;
    objCounter?: Object;
    objDate?: Object;
    objTime: Object;
    objValEdit: Object;
    objId: Object;

    constructor( objLot: Object, objSubstation: Object, objCounter: Object,
                 objDate: Object, objTime: Object, objValEdit: Object, objId: Object ) {
        this.objLot = objLot;
        this.objSubstation = objSubstation;
        this.objCounter = objCounter;
        this.objDate = objDate;
        this.objTime = objTime;
        this.objValEdit = objValEdit;
        this.objId = objId;
    }

}
export { FormSelectValueField }