import Centrifuge = require("centrifuge");
import axios from "axios";

export default class Centrifugo extends Centrifuge {

    private genTokenUrl: string;
    private token: string;

    public constructor(url: string, genTokenUrl: string, options?: Centrifuge.Options) {
        super(url, options);
        this.genTokenUrl = genTokenUrl;
    }

    public connect(): void {
        this.initToken().then(() => {
            this.setToken(this.token);
            super.connect();
        });
    }

    public async initToken(): Promise<void> {
        let token: string | null = localStorage.getItem('centrifugo_token');
        if (token === null || token === "" || token === "undefined") {
            await axios.post(this.genTokenUrl)
                .then((response) => {
                    this.token = response.data.token;
                    localStorage.setItem('centrifugo_token', this.token);
                });
        } else {
            this.token = localStorage.getItem('centrifugo_token');
        }
    }

}
