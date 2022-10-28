import getAccessToken from "./getAccessToken";

export interface GdiHostInterface {
    getAccessToken: () => Promise<string>;
}

window.gdiHost = {
    getAccessToken,
}