import { setBodyClass } from './body-class';
import { triggerPressOnDomLoaded } from './trigger-press';
import { reloadPageWhenTokenExpires } from './reload-page';

export interface ModMyPagesInterface {
  restUrl: string;
  noticeCodes: {
    INACTIVE_SIGNOUT: string;
  };
}

document.addEventListener('DOMContentLoaded', () => {
  setBodyClass();
  reloadPageWhenTokenExpires(10000);
  triggerPressOnDomLoaded();
});
