import { setBodyClass } from "./setBodyClass"

export interface ModMyPagesInterface {
    restUrl: string
}

document.addEventListener('DOMContentLoaded', () => {
    setBodyClass();
});