export type GetAccessTokenResponse = {
    token: string,
    expires: number
}

export type GetAccessToken = () => Promise<GetAccessTokenResponse>;

export interface GdiHostInterface {
    getAccessToken: GetAccessToken;
}