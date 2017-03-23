/**
 * Created by valik on 23.03.2017.
 */
class RenderCounter {
    protected dest: any;
    protected html: string;

    constructor( dest: Object ) {
        this.dest = dest;
    };

    public doRun( data ) {
        let options = '';
        $( data ).each( function () {
            options += '<option value="' + $( this ).attr( 'Ref' ) + '">' + $( this ).attr( 'DescriptionRu' ) + '</option>';
        } );
        this.html = options;
    }

    public render() {
        let out = this.dest;
        out.html( this.html );
    }
}
export { RenderCounter };