import { setBodyClass } from "./body-class";
import { reloadPageWhenTokenExpires } from "./reload-page";

export interface ModMyPagesInterface {
    restUrl: string
}

document.addEventListener('DOMContentLoaded', () => {
    setBodyClass();
    reloadPageWhenTokenExpires(10000);
});