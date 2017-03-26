interface OptionData {
    id: string;
    name: string;
}

export default class Select {
    private onChange: Function;
    private el: HTMLSelectElement;
    private data: OptionData[];

    constructor() {
        this.onChange = null;
        this.data = [];
        this.el = null;
    }

    public setData(data: OptionData[]) {
        this.data = data;
        this.render();
    }

    public selectById(id): boolean {
        return !!this.el && this.data.some((item, index) => {
            if (item.id === id) {
                this.el.selectedIndex = index;
                return true;
            }

            return false;
        });
    }

    public render() {
        const select = document.createElement('select');

        this.data.forEach((item) => {
            select.options.add(new Option(item.name, item.id));
        });

        if (this.el && this.el.parentNode) {
            this.el.parentNode.replaceChild( select, this.el );
        }

        this.el = select;

        return this.el;
    }
}

const one = new Select();
const two = new Select();

const oneEl = one.render();
const twoEl = two.render();

const data = [
    {name: 'test', id: '10'}
]

one.selectById('10');

oneEl.addEventListener('change', (ev) => {
    // ev.target.value
    setTimeout(() => {
        two.setData([]);
    });
});

document.body.appendChild(oneEl);
document.body.appendChild(twoEl);
