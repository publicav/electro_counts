import { Render } from "./Render";
import { RenderSubstation } from "./RenderSubstation";
import { ReqestData } from "./ReqestData";

/**
 * Created by valik on 25.03.2017.
 */
class LoadFormValue implements Render {
    protected dest: any;
    protected renderSubstation: RenderSubstation;
    protected html: string;
    protected _value: number;
    protected data: any;

    constructor( renderSubstation: RenderSubstation, dest: any ) {
        this.renderSubstation = renderSubstation;
        this.dest = dest;
    };

    public before() {
    }

    public after() {

    }

    public doRun( data ) {
        this.data = data;
        this.dest.objLot.find( '[value="' + data.lot_id + '"]' ).prop( "selected", true );

//            get_substation( obj, data.lot_id, 2, data.sub_id, data.counter_id );
        this.dest.objDate.val( data.date1 );
        this.dest.objTime.val( data.time1 );
        this.dest.objValEdit.val( data.value );
        this.dest.objId.val( data.id );
    }

    public render() {
        let value: number = this.data.lot_id;
        if ( value != 0 ) {
            this.renderSubstation.Value1 = this.data.sub_id;
            this.renderSubstation.valuecounter = this.data.counter_id;
        }
        console.log( 'Test subst = ', this.renderSubstation.Value );
        console.log( "Lot = ", value, "Substation = ", this.data.sub_id );
        const ReqestSubstation: ReqestData = new ReqestData( this.renderSubstation, 'ajax/subst/', { data: value }, 'get' );
        ReqestSubstation.reqest();

    }
}
export { LoadFormValue };