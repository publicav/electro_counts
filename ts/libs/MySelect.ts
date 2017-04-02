interface OptionData {
    id: string;
    name: string;
}

export default class Select {
    set classHTML( value: string ) {
        this._class = value;
    }

    private onChange: Function;
    private el: HTMLSelectElement;
    private data: OptionData[];
    private idEl: string;
    private _class: string;
    private elSetup: any;
    private elSelect2: any;
    private oneRun: number;

    constructor( idEl: string ) {
        this.onChange = null;
        this.data = [];
        this.idEl = idEl;
        this.elSetup = document.getElementById( idEl );
        // this.el = this.elSetup;
        this.elSelect2 = $( this.elSetup );
        this.elSelect2.select2( {
            MinimumResultsForSearch: Infinity
        } );
        this.oneRun = null;
    }

    public setData( data: OptionData[] ) {
        let dataSrc = [];

        for ( let row of data ) {
            dataSrc.push( {
                id: row.id,
                text: row.name
            } )
        }
        this.data = data;
        this.elSelect2.select2( {
            data: dataSrc
        } );

        this.render();
    }

    public selectByValue( id ) {

        this.elSelect2.select2( 'val', id );
        // return !!this.el && this.data.some( ( item, index ) => {
        //         if ( item.id === id ) {
        //             this.el.selectedIndex = index;
        //             return true;
        //         }
        //
        //         return false;
        //     } );
    }

    public render() {
        //
        // t select = document.createElement( 'select' );
        // select.setAttribute( "id", this.idEl );
        // select.setAttribute( 'name', this.idEl );
        // select.setAttribute( 'class', this._class );
        //
        // this.data.forEach( ( item ) => {
        //     select.options.add( new Option( item.name, item.id ) );
        // } );
        //
        // if ( this.el && this.el.parentNode ) {
        //     this.el.parentNode.replaceChild( select, this.el );
        // }
        //
        // if ( this.oneRun ==null) $( select ).select2();
        // this.el = select;
        // this.oneRun = 1;
        // return this.el;
    }
}

// const one = new Select( 'one' );
// const two = new Select( 'two' );
//
// const oneEl = one.render();
// const twoEl = two.render();
//
// const data = [
//     { name: 'test', id: '10' }
// ]
//
// one.selectById( '10' );
//
// oneEl.addEventListener( 'change', ( ev ) => {
//     // ev.target.value
//     console.log( ev.target );
//     setTimeout( () => {
//         // two.setData( [] );
//     } );
// } );
//
// document.body.appendChild( oneEl );
// document.body.appendChild( twoEl );
