interface OptionData {
    id: string;
    name: string;
}

export default class Select {
    private onChange: Function;
    private el: HTMLSelectElement;
    private data: OptionData[];
    private idEl: string;
    private elSetup: any;

    constructor( idEl: string ) {
        this.onChange = null;
        this.data = [];
        this.idEl = idEl;
        this.elSetup = document.getElementById( idEl );
        this.el = this.elSetup;
    }

    public setData( data: OptionData[] ) {
        this.data = data;
        this.render();
    }

    public selectByValue( id ): boolean {

        return !!this.el && this.data.some( ( item, index ) => {
                if ( item.id === id ) {
                    this.el.selectedIndex = index;
                    return true;
                }

                return false;
            } );
    }

    public render() {

        const select = document.createElement( 'select' );
        select.setAttribute( "id", this.idEl );
        select.setAttribute( 'name', this.idEl );

        this.data.forEach( ( item ) => {
            select.options.add( new Option( item.name, item.id ) );
        } );

        if ( this.el && this.el.parentNode ) {
            this.el.parentNode.replaceChild( select, this.el );
        }

        this.el = select;

        return this.el;
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
