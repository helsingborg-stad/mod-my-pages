import { setBodyClass } from './body-class';
import { triggerPressOnDomLoaded } from './trigger-press';
import { reloadPageWhenTokenExpires } from './reload-page';
import { replaceStrings } from './replace-strings';
import dropdown from './dropdown';
const { getAccessToken } = window.gdiHost;

export interface ModMyPagesInterface {
  restUrl: string;
  noticeCodes: {
    INACTIVE_SIGNOUT: string;
  };
}

document.addEventListener('DOMContentLoaded', async () => {
  const { token, expires, decoded } = await getAccessToken();
  const isAuthenticated = token.length > 0;

  if (isAuthenticated) {
    replaceStrings('.js-my-pages-template-string', { name: '', ...decoded });
    reloadPageWhenTokenExpires(expires);
  }

  if (!isAuthenticated) {
    triggerPressOnDomLoaded();
  }

  setBodyClass(isAuthenticated);
});
