import { Render } from "./Render";
/**
 * Created by valik on 23.03.2017.
 */
class RenderCounter implements Render {
    protected dest: any;
    protected html: string;
    protected _value: number = 0;

    constructor( dest: Object, value: number = 0 ) {
        this.dest = dest;
        this._value = value;
    };

    public set Value( value: number ) {
        this._value = value;
    }

    public before() {
        this.dest.prop( 'disabled', true );
        this.dest.html( '<option>загрузка...</option>' );
    }

    public after() {
        this.dest.prop( 'disabled', false );
    }

    public doRun( data ) {
        let options = '';
        $( data ).each( function () {
            options += '<option value="' + $( this ).attr( 'id' ) + '">' + $( this ).attr( 'name' ) + '</option>';
        } );
        this.html = options;
    }

    public render() {
        let out = this.dest;
        let value = this._value;
        out.html( this.html );
        if ( value != 0 ) out.find( '[value="' + value + '"]' ).prop( "selected", true );

    }
}
export { RenderCounter };