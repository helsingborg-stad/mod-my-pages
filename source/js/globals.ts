import { GdiHostInterface } from "./GdiHost"
import { ModMyPagesInterface } from "./mod-my-pages"

declare global {
    interface Window {
        gdiHost: GdiHostInterface,
        modMyPages: ModMyPagesInterface
    }
}