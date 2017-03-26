/**
 * Created by valik on 25.03.2017.
 */
interface Render {
    before(): void;
    doRun( data ): void;
    render(): void;
    after(): void;
}
export { Render };
