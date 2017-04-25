import ReqestSelect from "./ReqestSelect";
import Select from "./MySelect";

/**
 * Created by valik on 24.04.2017.
 */
interface iReqestRender {
    render: Select;
    url: string;
}
interface isetParam1 {
    setparam: number;
}


export default class ReqestSelectLastVal extends ReqestSelect {
    set lastEl( value: JQuery ) {
        this._lastEl = value;
    }

    private _lastEl: JQuery;

    protected get_last_val() {
        $.ajax( { dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: { 'counter': this.data } } )
            .done( ( result ) => {
                let data = result.data;
                this._lastEl.val( data.value );
            } )
            .fail( ( result ) => alert( 'Error' ) );
    };

    public reqestMod() {
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
                    if ( this.reqRender.length == 1 ) this.get_last_val();
                    console.log( 'размер массива', this.reqRender.length );
                    this.reqestMod();

                } )
                .fail( ( result ) => alert( 'error' ) );
        }
//        this.get_last_val();
    }

}
export { iReqestRender, isetParam1, ReqestSelectLastVal }
