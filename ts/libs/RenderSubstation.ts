import { Render } from "./Render";
import { RenderCounter } from "./RenderCounter";
import { ReqestData } from "./ReqestData";
/**
 * Created by valik on 23.03.2017.
 */
class RenderSubstation implements Render {
    protected dest: any;
    protected renderCounter: RenderCounter;
    protected data: Object;
    protected html: string;
    protected _value: number;
    protected _valuecounter: number = 0;

    constructor( dest: Object, renderCounter: RenderCounter, value: number = 0 ) {
        this.dest = dest;
        this.renderCounter = renderCounter;
        this._value = value;
    };

    public set Value1( value: number ) {
        this._value = value;
    }

    public set valuecounter( value: number ) {
        this._valuecounter = value;
    }

    public get Value() {
        return this._value;
    }

    public before() {
        this.dest.prop( 'disabled', true );
        this.dest.html( '<option>загрузка...</option>' );
    }

    public after() {
        this.dest.prop( 'disabled', false );
    }

    public doRun( data ) {
        this.data = data;
        let options = '';
        $( data ).each( function () {
            options += '<option value="' + $( this ).attr( 'id' ) + '">' + $( this ).attr( 'name' ) + '</option>';
        } );
        this.html = options;
    }

    public render() {
        let out = this.dest;
        let value: number = this._value;
        out.html( this.html );
        if ( value != 0 ) {
            out.prop( 'disabled', true );
            out.find( '[value="' + value + '"]' ).prop( "selected", true );
            this.renderCounter.Value = this._valuecounter;
        } else {
            this.renderCounter.Value = 0;
            value = this.data[0].id;
        }
        console.log( 'Substation = ', this._value );
        const ReqestCount: ReqestData = new ReqestData( this.renderCounter, 'ajax/counter/', { data: value }, 'get' );
        ReqestCount.reqest();


    }
}
export { RenderSubstation };