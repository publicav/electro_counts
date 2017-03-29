/**
 * Created by valik on 29.03.2017.
 */
// import * as data from './example.json'
// import loadJsonFile from 'load-json-file';

interface iTitle {
    "class": string;
    "name": string;
}
export default class RenderTablValCounter {
    protected title: iTitle[] = [
        {
            "class": "title_lots",
            "name": "Участок"
        },
        {
            "class": "title_substation",
            "name": "Подстанция"
        },
        {
            "class": "title_counts",
            "name": "Ячейка"
        },
        {
            "class": "title_date",
            "name": "Дата"
        },
        {
            "class": "title_value",
            "name": "Значение"
        }

    ];

    protected test: any;

    constructor() {
        console.log( 'RenderTablValCounter' );
        // loadJsonFile( './../../json/title-tabl-val-counter.json' )
        //     .then( json => {
        //         console.log( json );
        //     } );
        // this.test = require( "./../../json/title-tabl-val-counter.json" );
        // require( [ 'json!./../../json/title-tabl-val-counter.json' ], function ( data ) {
        //     this.test = data;
        // } )
        // this.test = require( "json!./../../json/title-tabl-val-counter.json" );
        // console.log( this.test );
    }

    public titleRender() {
        let divMain = document.createElement( 'div' );
        divMain.setAttribute( 'class', 'title_table_counter' );
        let st = `<div class="title_table_counter">`;
        for ( let row of this.title ) {
            let div = document.createElement( 'div' );
            div.setAttribute( 'class', row.class );
            div.innerHTML = row.name;
            divMain.appendChild( div );
            st += `<div class="${row.class}">${row.name}</div>`;
        }
        st += `</div>`;
        let right = document.getElementById('right');
        rigth.appendChild( divMain );

        console.log( divMain );
    }
}
