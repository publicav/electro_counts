/**
 * Created by valik on 26.03.2017.
 */
class ActionForm {
    protected _form: any;
    protected _modeAction: string = '';

    constructor( form ) {
        this._form = form;
    }

    set setModeAction( action: string ) {
        this._modeAction = action;
    }

    public doActions() {
        let formActions = $( this._form );

        let m_method = formActions.attr( 'method' );
        let m_action = formActions.attr( 'action' );
        let m_data = formActions.serialize();
        if ( this._modeAction != '' ) m_data += `&actions=${this._modeAction}`;

        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                if ( result.success ) {
                } else  alert( result.error );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );

    }
}
export { ActionForm };
