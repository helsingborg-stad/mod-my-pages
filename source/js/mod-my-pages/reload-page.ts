import { getAccessToken } from "../gdi-host/access-token";

export const reloadPageWhenTokenExpires = async (frequencyInMs: number) => {
    const delayPromise = (delayInMs: number): Promise<void> =>
        new Promise((resolve) => setTimeout(resolve, delayInMs))

    const timestampInSeconds = (): number =>
        Math.floor(Date.now() / 1000);

    const tryReloadPageRecursively = (): Promise<void> =>
        delayPromise(frequencyInMs)
            .then(getAccessToken)
            .then(({ expires }) =>
                timestampInSeconds() >= expires
                    ? location.reload()
                    : tryReloadPageRecursively()
            );

    [await getAccessToken()]
        .map(({ expires }) => expires > 0)
        .filter((isLoggedIn) => isLoggedIn)
        .forEach(tryReloadPageRecursively);
}