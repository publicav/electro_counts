import Select from "./MySelect";
/**
 * Created by valik on 28.03.2017.
 */
interface iReqestRender {
    render: Select;
    url: string;
}
interface isetParam1 {
    setparam: number;
}
export default class ReqestSelect {
    get data(): number {
        return this._data;
    }
    set data( value: number ) {
        this._data = value;
    }
    set param( value: isetParam1[] ) {
        this._param = value;
    }

    protected reqRender: iReqestRender[];
    protected loadForm: number;
    protected _data: number;
    protected _param: isetParam1[] = [];

    constructor( reqRender: iReqestRender[], loadForm: number = 0 ) {
        this.reqRender = reqRender;
        this.loadForm = loadForm;
        this._data = 0;
    }


    public reqest() {
        if ( this.reqRender.length ) {
            let me = this.reqRender.shift();
            let param = this._param.shift();
            console.log( param );
            $.ajax( { dataType: 'json', type: 'get', url: me.url, data: { 'data': this._data } } )
                .done( ( result ) => {
                    me.render.setData( result.data );
                    if ( this.loadForm ) {
                        // console.log( param );
                        me.render.selectByValue( param.setparam.toLocaleString() );
                        this._data = param.setparam;
                    } else {
                        this._data = result.data[ 0 ].id;
                    }
                    // console.log( result );
                    this.reqest();
                } )
                .fail( ( result ) => alert( 'error' ) );
        }
    }
}
export { iReqestRender, isetParam1, ReqestSelect }