const { getAccessToken } = window.gdiHost;
const {
  noticeCodes: { INACTIVE_SIGNOUT },
} = window.modMyPages;

export const reloadPageWhenTokenExpires = async (expires: number) => {
  const timestampInSeconds = (): number => Math.floor(Date.now() / 1000);

  const halfTimeOfExpiryDate = (expiresInSeconds: number) =>
    (expiresInSeconds - timestampInSeconds()) / 2;

  const toMs = (seconds: number) => seconds * 1000;

  const delayPromise = (delayInMs: number): Promise<void> =>
    new Promise((resolve) => setTimeout(resolve, delayInMs));

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

  const tryReloadPageRecursively = (delayInMs: number = 0): Promise<void> =>
    delayPromise(delayInMs)
      .then(getAccessToken)
      .then(({ expires }) =>
        timestampInSeconds() >= expires
          ? reloadPage()
          : tryReloadPageRecursively(toMs(halfTimeOfExpiryDate(expires))),
      );

  [expires]
    .filter((exp) => exp > 0)
    .map((exp) => toMs(halfTimeOfExpiryDate(exp)))
    .forEach(tryReloadPageRecursively);
};
