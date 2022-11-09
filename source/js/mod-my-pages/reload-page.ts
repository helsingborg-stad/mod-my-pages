import { getAccessToken } from "../gdi-host/access-token"

export const reloadPageWhenTokenExpires = async (frequencyInMs: number) => {
    const timestampInSeconds = (): number =>
        Math.floor(Date.now() / 1000);

    const tryReloadPage = (): any =>
        new Promise((resolve) => setTimeout(resolve, frequencyInMs))
            .then(() => getAccessToken())
            .then(({ expires }) => timestampInSeconds() >= expires
                ? location.reload()
                : tryReloadPage()
            );

    [await getAccessToken()]
        .map(({ expires }) => expires > 0)
        .filter((isLoggedIn) => isLoggedIn)
        .forEach(tryReloadPage);
}