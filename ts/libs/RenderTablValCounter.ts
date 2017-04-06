import { Render } from "./Render";
/**
 * Created by valik on 29.03.2017.
 */
// import * as data from './example.json'
// import loadJsonFile from 'load-json-file';

interface iTitle {
    "class": string;
    "name": string;
}
export default class RenderTablValCounter implements Render {

    get elnavigator(): HTMLDivElement {
        return this._elnavigator;
    }

    get elTable(): HTMLDivElement {
        return this._elTable;
    }

    get elTitle(): HTMLDivElement {
        return this._elTitle;
    }

    protected title: iTitle[];
    private _elTitle: HTMLDivElement;
    private _elTable: HTMLDivElement;
    private _elnavigator: HTMLDivElement;
    protected navigator: any;
    protected table: any;
    protected elSetup;

    constructor( idEl: string ) {
        this._elTitle = null;
        this._elTable = null;
        this._elnavigator = null;
        this.elSetup = $( document.getElementById( idEl ) );
        console.log( 'RenderTablValCounter' );
        this.title = require( './../../json/title-tabl-counter.json' );
    }

    protected titleRender() {
        const divMain = document.createElement( 'div' );
        divMain.setAttribute( 'class', 'title_table_counter' );
        for ( let row of this.title ) {
            const div = document.createElement( 'div' );
            div.setAttribute( 'class', row.class );
            div.innerHTML = row.name;
            divMain.appendChild( div );
        }
        // if ( this._elTitle && this._elTitle.parentNode ) {
        //     this._elTitle.parentNode.replaceChild( divMain, this._elTitle );
        // }
        this._elTitle = divMain;
        return this._elTitle;
        // console.log( divMain );
    }

    protected navigationRender() {
        let divNavig = document.createElement( 'div' );
        divNavig.setAttribute( 'class', 'navigator' );
        if ( this._elnavigator != null ) {
            let nav = this.navigator;
            let page = nav.page;
            let span = '';
            let pNavig = document.createElement( 'p' );
            for ( let row of  page ) {
                if ( row.st == null ) {
                    span = `<span class="pagecurrent">${row.text}</span>`;
                } else {
                    span = `<span class="pagelink"><a href="${nav.file}?st=${row.st}${nav.paramUrl}" title="${row.title}">${row.text}</a></span>`;
                }
                pNavig.innerHTML += span;
            }
            divNavig.appendChild( pNavig );
        }
        this._elnavigator = divNavig;
        // if ( this._elnavigator && this._elnavigator.parentNode ) {
        //     this._elnavigator.parentNode.replaceChild( divNavig, this._elnavigator );
        // }
    }

    public after() {

    }

    public before() {

    }

    public doRun( data ) {
        this.navigator = data.navigationData;
        this.table = data.counter;
        // console.log( data );
    }

    protected tableRender() {
        let divMain = document.createElement( 'div' );
        if ( this._elTable != null ) {
            let tabl = this.table;
            let count: number = 0;
            let class_e;
            let st;
            for ( let row of tabl ) {
                if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
                let divRow = document.createElement( 'div' );
                divRow.setAttribute( 'class', class_e );
                divRow.setAttribute( 'id', `id_${row.id}` );
                divRow.setAttribute( 'title', `Ввод - <b>${row.name_user}</b>` );

                st = `<div class="col_lots">${row.lot}</div>
				   <div class="col_substation">${row.substation}</div>
				   <div class="col_counts">${row.counter}</div>
                   <div class="col_date">${row.date1}</div>
                   <div class="col_value">${row.value}</div>
			    `;
                divRow.innerHTML = st;
                count++;
                divMain.appendChild( divRow );

            }
        }
        // if ( this._elTable && this._elTable.parentNode ) {
        //     this._elTable.parentNode.replaceChild( divMain, this._elTable );
        // }
        this._elTable = divMain;

        // right.appendChild( divMain );
    }

    public render() {
        this.titleRender();
        this.tableRender();
        this.navigationRender();
        this.elSetup.html( this.elTitle );
        this.elSetup.append( this.elTable );
        this.elSetup.append( this.elnavigator );
    }

}
