import { getAccessToken, AccessTokenResponse } from "./access-token";

export interface GdiHostInterface {
    getAccessToken: () => Promise<AccessTokenResponse>;
}

window.gdiHost = {
    getAccessToken,
}