export interface ModMyPagesInterface {
    restUrl: string
}

export interface GdiHostInterface {
    getAccessToken: () => Promise<string>;
}

declare global {
    interface Window {
        gdiHost: GdiHostInterface,
        modMyPages: ModMyPagesInterface
    }
}