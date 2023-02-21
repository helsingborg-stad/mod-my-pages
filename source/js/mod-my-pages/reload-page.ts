import { GetAccessTokenResponse } from '../gdi-host/api';
const { getAccessToken } = window.gdiHost;
const {
  noticeCodes: { INACTIVE_SIGNOUT },
} = window.modMyPages;

export const reloadPageWhenTokenExpires = async (
  expires: number,
  frequencyInMs: number,
) => {
  const delayPromise = (delayInMs: number): Promise<void> =>
    new Promise((resolve) => setTimeout(resolve, delayInMs));

  const timestampInSeconds = (): number => Math.floor(Date.now() / 1000);

  const reloadPage = () => {
    const getQueryParams = (url: string): URLSearchParams =>
      new URL(url).searchParams;
    const withQueryParams =
      (queryParams: Record<string, string>) =>
      (params: URLSearchParams): URLSearchParams => {
        Object.entries(queryParams).forEach(([key, value]) => {
          params.set(key, value);
        });
        return params;
      };
    const toQueryString = (params: URLSearchParams): string =>
      `?${params.toString()}`;

    window.location.href = [
      `${window.location.protocol}//`,
      window.location.host,
      window.location.pathname,
      toQueryString(
        withQueryParams({ notice: INACTIVE_SIGNOUT })(
          getQueryParams(window.location.href),
        ),
      ),
    ].join('');
  };

  const tryReloadPageRecursively = (): Promise<void> =>
    delayPromise(frequencyInMs)
      .then(getAccessToken)
      .then(({ expires }) =>
        timestampInSeconds() >= expires
          ? reloadPage()
          : tryReloadPageRecursively(),
      );

  [expires]
    .map((expires) => expires > 0)
    .filter((isLoggedIn) => isLoggedIn)
    .forEach(tryReloadPageRecursively);
};
