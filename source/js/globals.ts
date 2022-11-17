import { GdiHostInterface } from "./gdi-host/api"
import { ModMyPagesInterface } from "./mod-my-pages"

declare global {
    interface Window {
        gdiHost: GdiHostInterface,
        modMyPages: ModMyPagesInterface
    }
}