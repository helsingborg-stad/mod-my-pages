import { setBodyClass } from './body-class';
import { triggerPressOnDomLoaded } from './trigger-press';
import { reloadPageWhenTokenExpires } from './reload-page';
import { replaceStrings } from './replace-strings';
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
    replaceStrings('.js-my-pages-string', { name: '', ...decoded });
    reloadPageWhenTokenExpires(expires, 10000);
  }

  if (!isAuthenticated) {
    triggerPressOnDomLoaded();
  }

  setBodyClass(isAuthenticated);
});
