import { setBodyClass } from "./body-class";

export interface ModMyPagesInterface {
    restUrl: string
}

document.addEventListener('DOMContentLoaded', () => {
    setBodyClass();
});