import { Render } from "./Render";
import ReqestSelect from "./ReqestSelect";
/**
 * Created by valik on 25.03.2017.
 */
class LoadFormValue implements Render {

    protected dest: any;
    protected renderSel: ReqestSelect;
    protected html: string;
    protected _value: number;
    public _data: any;

    constructor( renderSel: ReqestSelect, dest: any ) {
        this.renderSel = renderSel;
        this.dest = dest;
    };

    public before() {
    }

    public after() {

    }

    public doRun( data ) {
        this._data = data;
        // this.dest.objLot.find( '[value="' + data.lot_id + '"]' ).prop( "selected", true );

//            get_substation( obj, data.lot_id, 2, data.sub_id, data.counter_id );
        this.dest.objDate.val( data.date1 );
        this.dest.objTime.val( data.time1 );
        this.dest.objValEdit.val( data.value );
        this.dest.objId.val( data.id );
    }


    public render() {
        let lf = this._data;
        console.log( lf )
        const param = [ { setparam: lf.lot_id }, { setparam: lf.sub_id }, { setparam: lf.counter_id } ];
        this.renderSel.param = param;
        this.renderSel.reqest();
    }
}
export { LoadFormValue };