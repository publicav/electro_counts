/**
 * Created by valik on 25.03.2017.
 */
import { Render } from "./Render"
class ReqestData {
    protected render: Render;
    protected data: Object = {};
    protected url: string = '';
    protected type: string = '';

    constructor( render, url, param = {}, type = 'post' ) {
        this.data = param;
        this.render = render;
        this.url = url;
        this.type = type;
    }

    public reqest() {
        let me = this;
        me.render.before();
        $.ajax( { dataType: 'json', type: me.type, url: me.url, data: me.data } )
            .done( ( result ) => {
                console.log( result );
                me.render.doRun( result.data );
                me.render.render();
                me.render.after();
            } )
            .fail( ( result ) => alert( 'error' ) );
            // .fail( ( result ) => alert( result.responseJSON.error ) );

    }
}
export { ReqestData };
